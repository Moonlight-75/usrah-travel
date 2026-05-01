<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Document;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __invoke(Request $request)
    {
        $period = $request->get('period', 'this_year');

        if ($period === 'this_year') {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
            $label = now()->format('Y');
        } elseif ($period === 'last_year') {
            $startDate = now()->subYear()->startOfYear();
            $endDate = now()->subYear()->endOfYear();
            $label = now()->subYear()->format('Y');
        } elseif ($period === 'last_6_months') {
            $startDate = now()->subMonths(5)->startOfMonth();
            $endDate = now()->endOfMonth();
            $label = 'Last 6 Months';
        } else {
            $startDate = now()->subMonths(2)->startOfMonth();
            $endDate = now()->endOfMonth();
            $label = 'Last 3 Months';
        }

        $monthlyRevenue = Payment::where('status', 'verified')
            ->whereBetween('paid_date', [$startDate, $endDate])
            ->selectRaw("DATE_FORMAT(paid_date, '%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlyBookings = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = [];
        $start = $startDate->copy();
        while ($start->lte($endDate)) {
            $key = $start->format('Y-m');
            $months[$key] = $start->format('M');
            $start->addMonth();
        }

        $revenueChartData = [];
        $bookingChartData = [];
        foreach ($months as $key => $label) {
            $revenueChartData[] = ['month' => $label, 'value' => (float) ($monthlyRevenue[$key] ?? 0)];
            $bookingChartData[] = ['month' => $label, 'value' => (int) ($monthlyBookings[$key] ?? 0)];
        }

        $bookingStatuses = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalRevenue = $monthlyRevenue->sum();
        $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->count();
        $activeCustomers = Customer::whereHas('bookings', fn ($q) => $q->whereBetween('created_at', [$startDate, $endDate]))->count();
        $avgBookingValue = $totalBookings > 0
            ? Booking::whereBetween('created_at', [$startDate, $endDate])->avg('total_amount')
            : 0;

        $topPackages = Package::withCount(['bookings' => fn ($q) => $q->whereBetween('created_at', [$startDate, $endDate])])
            ->withSum(['bookings' => fn ($q) => $q->whereBetween('created_at', [$startDate, $endDate])], 'total_amount')
            ->having('bookings_count', '>', 0)
            ->orderByDesc('bookings_sum_total_amount')
            ->take(5)
            ->get();

        $paymentMethods = Payment::where('status', 'verified')
            ->whereBetween('paid_date', [$startDate, $endDate])
            ->selectRaw('method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('method')
            ->orderByDesc('total')
            ->get();

        $paymentStatuses = Payment::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $pendingPaymentsCount = $paymentStatuses['pending']->count ?? 0;
        $pendingPaymentsAmount = $paymentStatuses['pending']->total ?? 0;
        $rejectedPaymentsCount = $paymentStatuses['rejected']->count ?? 0;

        $documentStats = Document::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $totalDocuments = $documentStats->sum('count');
        $approvedDocuments = $documentStats['approved']->count ?? 0;
        $pendingDocuments = $documentStats['pending']->count ?? 0;
        $rejectedDocuments = $documentStats['rejected']->count ?? 0;

        $recentBookings = Booking::with(['customer.user', 'package'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $customerGrowth = Customer::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $customerChartData = [];
        foreach ($months as $key => $label) {
            $customerChartData[] = ['month' => $label, 'value' => (int) ($customerGrowth[$key] ?? 0)];
        }

        $newContacts = Contact::whereBetween('created_at', [$startDate, $endDate])->count();
        $unreadContacts = Contact::where('status', 'new')->count();

        return view('admin.reports', compact(
            'period', 'label',
            'revenueChartData', 'bookingChartData', 'customerChartData',
            'months',
            'bookingStatuses',
            'totalRevenue', 'totalBookings', 'activeCustomers', 'avgBookingValue',
            'topPackages', 'paymentMethods',
            'pendingPaymentsCount', 'pendingPaymentsAmount', 'rejectedPaymentsCount',
            'totalDocuments', 'approvedDocuments', 'pendingDocuments', 'rejectedDocuments',
            'recentBookings',
            'newContacts', 'unreadContacts',
        ));
    }
}

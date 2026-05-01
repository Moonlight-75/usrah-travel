<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $totalBookings = Booking::count();
        $activeBookings = Booking::whereIn('status', ['confirmed', 'deposit_paid', 'fully_paid', 'visa_processing', 'visa_approved', 'departed'])->count();
        $totalRevenue = Payment::where('status', 'verified')->sum('amount');
        $totalCustomers = Customer::count();
        $totalPackages = Package::where('is_active', true)->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $newContacts = Contact::where('status', 'new')->count();

        $recentBookings = Booking::with(['customer.user', 'package'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingTours = Booking::with(['customer.user', 'package'])
            ->where('status', 'confirmed')
            ->where('travel_date', '>=', now())
            ->orderBy('travel_date')
            ->take(5)
            ->get();

        $monthlyBookings = Booking::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->take(6)
            ->pluck('count', 'month');

        $bookingStatuses = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.dashboard', compact(
            'totalBookings', 'activeBookings', 'totalRevenue', 'totalCustomers',
            'totalPackages', 'pendingPayments', 'newContacts',
            'recentBookings', 'upcomingTours',
            'monthlyBookings', 'bookingStatuses'
        ));
    }
}

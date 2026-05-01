<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    private function getCustomer()
    {
        return Customer::where('user_id', auth()->id())->firstOrFail();
    }

    public function dashboard()
    {
        $customer = $this->getCustomer();

        $totalBookings = $customer->bookings()->count();
        $activeBookings = $customer->bookings()->whereIn('status', ['confirmed', 'deposit_paid', 'fully_paid', 'visa_processing', 'visa_approved', 'departed'])->count();
        $totalSpent = $customer->bookings()->where('status', '!=', 'cancelled')->sum('paid_amount');
        $pendingDocuments = $customer->documents()->where('status', 'pending')->count();

        $upcomingBookings = $customer->bookings()
            ->whereIn('status', ['confirmed', 'deposit_paid', 'fully_paid', 'visa_processing', 'visa_approved'])
            ->where('travel_date', '>=', now())
            ->orderBy('travel_date')
            ->take(3)
            ->get();

        $recentBookings = $customer->bookings()
            ->with('package')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('portal.dashboard', compact(
            'customer', 'totalBookings', 'activeBookings', 'totalSpent', 'pendingDocuments',
            'upcomingBookings', 'recentBookings'
        ));
    }

    public function bookings(Request $request)
    {
        $customer = $this->getCustomer();

        $query = $customer->bookings()->with('package');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_ref', 'like', "%{$search}%")
                  ->orWhereHas('package', fn ($pq) => $pq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('portal.bookings.index', compact('bookings'));
    }

    public function bookingDetail(string $id)
    {
        $customer = $this->getCustomer();

        $booking = Booking::with(['package', 'payments', 'invoice', 'documents'])
            ->where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        return view('portal.bookings.show', compact('booking'));
    }

    public function cancelBooking(Request $request, string $id)
    {
        $customer = $this->getCustomer();

        $booking = Booking::where('id', $id)
            ->where('customer_id', $customer->id)
            ->whereIn('status', ['inquiry', 'confirmed', 'deposit_paid'])
            ->firstOrFail();

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'cancelled',
            'cancelled_reason' => $request->reason,
            'cancelled_at' => now(),
        ]);

        return redirect()->route('portal.bookings.show', $id)
            ->with('success', 'Booking cancelled successfully.');
    }

    public function documents()
    {
        $customer = $this->getCustomer();

        $documents = $customer->documents()
            ->with('booking')
            ->orderByDesc('created_at')
            ->paginate(10);

        $bookings = $customer->bookings()->whereIn('status', ['confirmed', 'deposit_paid', 'fully_paid', 'visa_processing', 'visa_approved'])->pluck('id', 'booking_ref');

        return view('portal.documents.index', compact('documents', 'bookings'));
    }

    public function uploadDocument(Request $request)
    {
        $customer = $this->getCustomer();

        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'type' => 'required|in:passport,visa,medical,insurance,other',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $booking = Booking::where('id', $request->booking_id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        $file = $request->file('file');
        $path = $file->store("documents/{$customer->id}", 'public');

        $customer->documents()->create([
            'booking_id' => $booking->id,
            'type' => $request->type,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'status' => 'pending',
        ]);

        return redirect()->route('portal.documents.index')
            ->with('success', 'Document uploaded and pending review.');
    }

    public function downloadDocument(string $id)
    {
        $customer = $this->getCustomer();

        $document = Document::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    public function payments()
    {
        $customer = $this->getCustomer();

        $payments = Payment::whereHas('booking', function ($q) use ($customer) {
            $q->where('customer_id', $customer->id);
        })
            ->with('booking.package')
            ->orderByDesc('created_at')
            ->paginate(10);

        $totalPaid = Payment::whereHas('booking', function ($q) use ($customer) {
            $q->where('customer_id', $customer->id);
        })->where('status', 'verified')->sum('amount');

        $pendingPayments = Payment::whereHas('booking', function ($q) use ($customer) {
            $q->where('customer_id', $customer->id);
        })->where('status', 'pending')->count();

        return view('portal.payments.index', compact('payments', 'totalPaid', 'pendingPayments'));
    }

    public function profile()
    {
        $customer = $this->getCustomer();

        return view('portal.profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = $this->getCustomer();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'ic_passport_no' => 'nullable|string|max:50',
            'ic_passport_expiry' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'emergency_name' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'emergency_relation' => 'nullable|string|max:100',
        ]);

        $customer->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $customer->update($request->only([
            'ic_passport_no', 'ic_passport_expiry',
            'address', 'city', 'state', 'postcode', 'country',
            'emergency_name', 'emergency_phone', 'emergency_relation',
        ]));

        return redirect()->route('portal.profile')
            ->with('success', 'Profile updated successfully.');
    }
}

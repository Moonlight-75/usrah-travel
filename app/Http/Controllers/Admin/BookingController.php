<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['customer.user', 'package']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('booking_ref', 'like', "%{$search}%")
                  ->orWhereHas('customer.user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('date_from')) {
            $query->where('travel_date', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->where('travel_date', '<=', $request->input('date_to'));
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $customers = Customer::with('user')->get();
        $packages = Package::where('is_active', true)->get();

        return view('admin.bookings.create', compact('customers', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'package_id' => 'required|exists:packages,id',
            'travel_date' => 'required|date|after:today',
            'return_date' => 'required|date|after:travel_date',
            'pax_adults' => 'required|integer|min:1',
            'pax_children' => 'nullable|integer|min:0',
            'pax_infants' => 'nullable|integer|min:0',
            'room_preference' => 'nullable|string|max:255',
            'special_requests' => 'nullable|string',
        ]);

        $package = Package::findOrFail($validated['package_id']);
        $totalPax = $validated['pax_adults'] + ($validated['pax_children'] ?? 0);
        $price = $package->discount_price ?? $package->price;

        $validated['total_amount'] = $price * $totalPax;
        $validated['paid_amount'] = 0;
        $validated['booking_ref'] = 'UT-' . strtoupper(Str::random(8));
        $validated['status'] = 'inquiry';

        if ($validated['special_requests']) {
            $validated['special_requests'] = ['notes' => $validated['special_requests']];
        }

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['customer.user', 'package', 'payments', 'invoice', 'tourGroup', 'documents']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $booking->load(['customer.user', 'package']);
        $packages = Package::where('is_active', true)->get();

        return view('admin.bookings.edit', compact('booking', 'packages'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'travel_date' => 'required|date',
            'return_date' => 'required|date|after:travel_date',
            'pax_adults' => 'required|integer|min:1',
            'pax_children' => 'nullable|integer|min:0',
            'pax_infants' => 'nullable|integer|min:0',
            'room_preference' => 'nullable|string|max:255',
            'special_requests' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'status' => 'nullable|in:inquiry,confirmed,deposit_paid,fully_paid,visa_processing,visa_approved,visa_rejected,departed,completed,cancelled,refunded',
            'cancelled_reason' => 'nullable|string',
        ]);

        if ($request->filled('status') && $request->input('status') === 'cancelled' && empty($validated['cancelled_reason'])) {
            return back()->withErrors(['cancelled_reason' => 'Cancellation reason is required when cancelling a booking.'])->withInput();
        }

        if ($request->filled('status') && $request->input('status') === 'cancelled') {
            $validated['cancelled_at'] = now();
        }

        if ($validated['special_requests']) {
            $validated['special_requests'] = ['notes' => $validated['special_requests']];
        } else {
            $validated['special_requests'] = null;
        }

        $hasVerifiedPayments = $booking->payments()->where('status', 'verified')->exists();

        if ($hasVerifiedPayments) {
            return back()->withErrors(['package_id' => 'Cannot update a booking that has verified payments. Refund or reject payments first.'])->withInput();
        }

        $package = Package::findOrFail($validated['package_id']);
        $totalPax = $validated['pax_adults'] + ($validated['pax_children'] ?? 0);
        $price = $package->discount_price ?? $package->price;
        $validated['total_amount'] = $price * $totalPax;

        $booking->update($validated);

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:inquiry,confirmed,deposit_paid,fully_paid,visa_processing,visa_approved,visa_rejected,departed,completed,cancelled,refunded',
            'cancelled_reason' => 'nullable|string',
        ]);

        if ($validated['status'] === 'cancelled' && empty($validated['cancelled_reason'])) {
            return back()->withErrors(['status' => 'Cancellation reason is required.']);
        }

        $booking->status = $validated['status'];

        if ($validated['status'] === 'cancelled') {
            $booking->cancelled_reason = $validated['cancelled_reason'];
            $booking->cancelled_at = now();
        }

        $booking->save();

        return back()->with('success', 'Booking status updated.');
    }
}

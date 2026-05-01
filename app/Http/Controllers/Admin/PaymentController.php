<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking.customer.user']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('payment_ref', 'like', "%{$search}%")
                  ->orWhereHas('booking', function ($q) use ($search) {
                      $q->where('booking_ref', 'like', "%{$search}%");
                  })
                  ->orWhereHas('booking.customer.user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $bookings = Booking::with('customer.user')->get();

        return view('admin.payments.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'type' => 'required|in:deposit,installment,full,refund',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:bank_transfer,cash,online,credit_card',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['payment_ref'] = 'PAY-' . strtoupper(Str::random(10));
        $validated['status'] = 'pending';

        Payment::create($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.customer.user', 'booking.package']);
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Payment $payment)
    {
        $payment->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'paid_date' => now()->toDateString(),
        ]);

        $booking = $payment->booking;
        $booking->paid_amount = $booking->payments()->where('status', 'verified')->sum('amount');
        $booking->save();

        return back()->with('success', 'Payment verified successfully.');
    }
}

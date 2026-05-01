@extends('layouts.admin')

@section('title', 'Payment Details')

@section('content')
@if (session('success'))
<div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
    {{ session('success') }}
</div>
@endif

<div class="mb-6">
    <a href="{{ route('admin.payments.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Payments</a>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Payment {{ $payment->payment_ref }}</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Info</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Payment Ref</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $payment->payment_ref }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Type</dt>
                    <dd class="mt-1">
                        @php $typeColors = ['deposit' => 'bg-blue-100 text-blue-700', 'installment' => 'bg-purple-100 text-purple-700', 'full' => 'bg-emerald-100 text-emerald-700', 'refund' => 'bg-orange-100 text-orange-700']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $typeColors[$payment->type] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($payment->type) }}</span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Amount</dt>
                    <dd class="mt-1 text-lg font-bold text-gray-900">RM{{ number_format($payment->amount, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Method</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ str_replace('_', ' ', ucfirst($payment->method)) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd class="mt-1">
                        @php $payStatusColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'verified' => 'bg-emerald-100 text-emerald-700', 'failed' => 'bg-red-100 text-red-700', 'refunded' => 'bg-orange-100 text-orange-700']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $payStatusColors[$payment->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($payment->status) }}</span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Due Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payment->due_date?->format('d M Y') ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Paid Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payment->paid_date?->format('d M Y') ?? '-' }}</dd>
                </div>
                @if ($payment->verified_at)
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Verified By</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payment->verifiedBy?->name ?? 'Unknown' }} at {{ $payment->verified_at->format('d M Y H:i') }}</dd>
                </div>
                @endif
            </dl>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Booking Information</h2>
            @if ($payment->booking)
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Booking Ref</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">
                        <a href="{{ route('admin.bookings.show', $payment->booking) }}" class="text-emerald-600 hover:text-emerald-700">{{ $payment->booking->booking_ref }}</a>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Customer</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payment->booking->customer?->user?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Package</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $payment->booking->package?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Total Amount</dt>
                    <dd class="mt-1 text-sm text-gray-900">RM{{ number_format($payment->booking->total_amount, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Paid Amount</dt>
                    <dd class="mt-1 text-sm text-emerald-600 font-medium">RM{{ number_format($payment->booking->paid_amount, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Booking Status</dt>
                    <dd class="mt-1">
                        @php $statusColors = ['inquiry' => 'bg-gray-100 text-gray-700', 'confirmed' => 'bg-blue-100 text-blue-700', 'deposit_paid' => 'bg-cyan-100 text-cyan-700', 'fully_paid' => 'bg-emerald-100 text-emerald-700']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$payment->booking->status] ?? 'bg-gray-100 text-gray-700' }}">{{ str_replace('_', ' ', ucfirst($payment->booking->status)) }}</span>
                    </dd>
                </div>
            </div>
            @else
            <p class="text-gray-500">No booking associated.</p>
            @endif
        </div>

        @if ($payment->notes)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Notes</h2>
            <p class="text-sm text-gray-700">{{ $payment->notes }}</p>
        </div>
        @endif

        @if ($payment->status === 'pending')
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions</h2>
            <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="inline">
                @csrf @method('PATCH')
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700">Verify Payment</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection

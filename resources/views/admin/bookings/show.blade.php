@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
@if (session('success'))
<div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
    {{ session('success') }}
</div>
@endif

<div class="mb-6">
    <a href="{{ route('admin.bookings.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Bookings</a>
</div>

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Booking {{ $booking->booking_ref }}</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.bookings.edit', $booking) }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700">Edit</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Status</h2>
            @php
                $statusColors = [
                    'inquiry' => 'bg-gray-100 text-gray-700', 'confirmed' => 'bg-blue-100 text-blue-700',
                    'deposit_paid' => 'bg-cyan-100 text-cyan-700', 'fully_paid' => 'bg-emerald-100 text-emerald-700',
                    'visa_processing' => 'bg-yellow-100 text-yellow-700', 'visa_approved' => 'bg-emerald-100 text-emerald-700',
                    'visa_rejected' => 'bg-red-100 text-red-700', 'departed' => 'bg-indigo-100 text-indigo-700',
                    'completed' => 'bg-emerald-100 text-emerald-700', 'cancelled' => 'bg-red-100 text-red-700',
                    'refunded' => 'bg-orange-100 text-orange-700',
                ];
            @endphp
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-700' }}">{{ str_replace('_', ' ', ucfirst($booking->status)) }}</span>

            <div class="mt-4" x-data="{ show: false }">
                <button @click="show = !show" type="button" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Update Status</button>
                <div x-show="show" x-cloak class="mt-3 p-4 bg-gray-50 rounded-lg">
                    <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}">
                        @csrf @method('PATCH')
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 mb-2">
                            @foreach (['inquiry','confirmed','deposit_paid','fully_paid','visa_processing','visa_approved','visa_rejected','departed','completed','cancelled','refunded'] as $s)
                            <option value="{{ $s }}" {{ $booking->status === $s ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($s)) }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="cancelled_reason" placeholder="Cancellation reason (if applicable)" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm mb-3">
                        <div class="flex gap-2">
                            <button type="submit" class="px-3 py-1.5 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700">Save</button>
                            <button @click="show = false" type="button" class="px-3 py-1.5 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Customer</h2>
            <dl class="space-y-2">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->customer?->user?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->customer?->user?->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Phone</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->customer?->user?->phone ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Package</h2>
            <dl class="space-y-2">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Package</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $booking->package?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Category</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->package?->category ? str_replace('_', ' ', ucfirst($booking->package->category)) : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Duration</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->package?->duration_days ?? '-' }}D / {{ $booking->package?->duration_nights ?? '-' }}N</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Booking Details</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Travel Date</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $booking->travel_date?->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Return Date</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $booking->return_date?->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Pax</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $booking->pax_adults }}A / {{ $booking->pax_children ?? 0 }}C / {{ $booking->pax_infants ?? 0 }}I</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Room Preference</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->room_preference ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Total Amount</dt>
                    <dd class="mt-1 text-sm font-bold text-gray-900">RM{{ number_format($booking->total_amount, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Paid Amount</dt>
                    <dd class="mt-1 text-sm font-bold text-emerald-600">RM{{ number_format($booking->paid_amount, 2) }}</dd>
                </div>
            </div>
            @if ($booking->special_requests)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <dt class="text-xs font-medium text-gray-500 uppercase">Special Requests</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ is_array($booking->special_requests) ? ($booking->special_requests['notes'] ?? '') : $booking->special_requests }}</dd>
            </div>
            @endif
            @if ($booking->admin_notes)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <dt class="text-xs font-medium text-gray-500 uppercase">Admin Notes</dt>
                <dd class="mt-1 text-sm text-gray-700">{{ $booking->admin_notes }}</dd>
            </div>
            @endif
            @if ($booking->cancelled_at)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <dt class="text-xs font-medium text-gray-500 uppercase">Cancellation</dt>
                <dd class="mt-1 text-sm text-red-600">{{ $booking->cancelled_reason }} — {{ $booking->cancelled_at->format('d M Y H:i') }}</dd>
            </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Payments ({{ $booking->payments->count() }})</h2>
            </div>
            @if ($booking->payments->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Ref</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Method</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($booking->payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $payment->payment_ref }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ ucfirst($payment->type) }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">RM{{ number_format($payment->amount, 2) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ str_replace('_', ' ', ucfirst($payment->method)) }}</td>
                            <td class="px-4 py-3">
                                @php $payColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'verified' => 'bg-emerald-100 text-emerald-700', 'failed' => 'bg-red-100 text-red-700', 'refunded' => 'bg-orange-100 text-orange-700']; @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $payColors[$payment->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($payment->status) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-6 text-center text-gray-500">No payments recorded.</div>
            @endif
        </div>

        @if ($booking->invoice)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Invoice</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Invoice No</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $booking->invoice->invoice_no }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Subtotal</dt>
                    <dd class="mt-1 text-sm text-gray-900">RM{{ number_format($booking->invoice->subtotal, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Total</dt>
                    <dd class="mt-1 text-sm font-bold text-gray-900">RM{{ number_format($booking->invoice->total, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd class="mt-1">
                        @php $invColors = ['draft' => 'bg-gray-100 text-gray-700', 'sent' => 'bg-blue-100 text-blue-700', 'paid' => 'bg-emerald-100 text-emerald-700', 'overdue' => 'bg-red-100 text-red-700', 'cancelled' => 'bg-gray-100 text-gray-700']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $invColors[$booking->invoice->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($booking->invoice->status) }}</span>
                    </dd>
                </div>
            </div>
        </div>
        @endif

        @if ($booking->documents->count())
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Documents ({{ $booking->documents->count() }})</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">File</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($booking->documents as $doc)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-900">{{ ucfirst($doc->type) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $doc->file_name }}</td>
                            <td class="px-4 py-3">
                                @php $docColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'approved' => 'bg-emerald-100 text-emerald-700', 'rejected' => 'bg-red-100 text-red-700']; @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $docColors[$doc->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($doc->status) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.portal')

@section('title', 'Booking ' . $booking->booking_ref)

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('portal.bookings.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">{{ $booking->booking_ref }}</h1>
        @php
            $badgeColors = [
                'inquiry' => 'bg-gray-100 text-gray-800',
                'confirmed' => 'bg-blue-100 text-blue-800',
                'deposit_paid' => 'bg-yellow-100 text-yellow-800',
                'fully_paid' => 'bg-green-100 text-green-800',
                'visa_processing' => 'bg-purple-100 text-purple-800',
                'visa_approved' => 'bg-indigo-100 text-indigo-800',
                'departed' => 'bg-emerald-100 text-emerald-800',
                'completed' => 'bg-green-200 text-green-900',
                'cancelled' => 'bg-red-100 text-red-800',
            ];
        @endphp
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
            {{ str_replace('_', ' ', ucfirst($booking->status)) }}
        </span>
    </div>
    <p class="text-gray-500">{{ $booking->package?->name ?? '—' }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 space-y-6">

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Trip Details</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Package</p>
                    <p class="text-sm text-gray-900 mt-1">{{ $booking->package?->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Travel Date</p>
                    <p class="text-sm text-gray-900 mt-1">{{ $booking->travel_date?->format('d M Y') ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Return Date</p>
                    <p class="text-sm text-gray-900 mt-1">{{ $booking->return_date?->format('d M Y') ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Duration</p>
                    <p class="text-sm text-gray-900 mt-1">
                        @if($booking->travel_date && $booking->return_date)
                            {{ $booking->travel_date->diffInDays($booking->return_date) }} days
                        @else
                            —
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Adults</p>
                    <p class="text-sm text-gray-900 mt-1">{{ $booking->pax_adults }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Children</p>
                    <p class="text-sm text-gray-900 mt-1">{{ $booking->pax_children ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Infants</p>
                    <p class="text-sm text-gray-900 mt-1">{{ $booking->pax_infants ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Room Preference</p>
                    <p class="text-sm text-gray-900 mt-1">{{ $booking->room_preference ?? '—' }}</p>
                </div>
            </div>
            @if($booking->special_requests)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs font-medium text-gray-500 uppercase">Special Requests</p>
                    <p class="text-sm text-gray-700 mt-1">{{ is_array($booking->special_requests) ? implode(', ', $booking->special_requests) : $booking->special_requests }}</p>
                </div>
            @endif
            @if($booking->admin_notes)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs font-medium text-gray-500 uppercase">Admin Notes</p>
                    <p class="text-sm text-gray-700 mt-1">{{ $booking->admin_notes }}</p>
                </div>
            @endif
            @if($booking->status === 'cancelled' && $booking->cancelled_reason)
                <div class="mt-4 pt-4 border-t border-red-100 bg-red-50 -mx-6 -mb-6 px-6 py-4 rounded-b-xl">
                    <p class="text-xs font-medium text-red-500 uppercase">Cancellation</p>
                    <p class="text-sm text-red-700 mt-1">{{ $booking->cancelled_reason }}</p>
                    <p class="text-xs text-red-400 mt-1">Cancelled on {{ $booking->cancelled_at?->format('d M Y, h:i A') }}</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment History</h2>
            @if($booking->payments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ref</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($booking->payments as $payment)
                                <tr>
                                    <td class="px-3 py-2 text-sm text-gray-900">{{ $payment->payment_ref }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-700">{{ ucfirst($payment->type) }}</td>
                                    <td class="px-3 py-2 text-sm font-medium text-gray-900">RM {{ number_format($payment->amount, 2) }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $payment->method ?? '—')) }}</td>
                                    <td class="px-3 py-2 text-sm">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                            {{ $payment->status === 'verified' ? 'bg-green-100 text-green-800' : ($payment->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-gray-400">No payments recorded yet.</p>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Documents</h2>
            @if($booking->documents->count() > 0)
                <div class="space-y-3">
                    @foreach($booking->documents as $doc)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="flex-shrink-0 w-8 h-8 bg-emerald-100 rounded flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $doc->file_name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst($doc->type) }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $doc->status === 'approved' ? 'bg-green-100 text-green-800' : ($doc->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($doc->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400">No documents uploaded yet.</p>
            @endif
        </div>
    </div>

    <div class="space-y-6">

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Summary</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Total Amount</span>
                    <span class="text-sm font-medium text-gray-900">RM {{ number_format($booking->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Paid</span>
                    <span class="text-sm font-medium text-green-600">RM {{ number_format($booking->paid_amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Balance</span>
                    <span class="text-sm font-bold {{ $booking->total_amount - $booking->paid_amount > 0 ? 'text-red-600' : 'text-green-600' }}">
                        RM {{ number_format($booking->total_amount - $booking->paid_amount, 2) }}
                    </span>
                </div>
                <div class="pt-3 border-t border-gray-100">
                    <div class="bg-gray-100 rounded-full h-2 overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-300"
                             style="width: {{ $booking->total_amount > 0 ? min(($booking->paid_amount / $booking->total_amount) * 100, 100) : 0 }}%; min-width: {{ $booking->paid_amount > 0 ? '4px' : '0' }};">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 text-right">
                        {{ $booking->total_amount > 0 ? round(($booking->paid_amount / $booking->total_amount) * 100) : 0 }}% paid
                    </p>
                </div>
            </div>

            @if($booking->invoice)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Invoice</p>
                            <p class="text-sm text-gray-900">{{ $booking->invoice->invoice_no }}</p>
                        </div>
                        <a href="{{ route('admin.invoices.download', $booking->invoice->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            PDF
                        </a>
                    </div>
                </div>
            @endif
        </div>

        @if(in_array($booking->status, ['inquiry', 'confirmed', 'deposit_paid']))
            <div class="bg-white rounded-xl shadow-sm p-6" x-data="{ showCancel: false }">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Actions</h2>
                <button @click="showCancel = !showCancel"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel Booking
                </button>

                <div x-show="showCancel" x-cloak x-transition class="mt-4">
                    <form method="POST" action="{{ route('portal.bookings.cancel', $booking->id) }}">
                        @csrf
                        <p class="text-sm text-red-600 mb-3">Are you sure? This action cannot be undone.</p>
                        <textarea name="reason" required rows="3"
                                  placeholder="Reason for cancellation..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 mb-3"></textarea>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">Confirm Cancel</button>
                            <button type="button" @click="showCancel = false" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

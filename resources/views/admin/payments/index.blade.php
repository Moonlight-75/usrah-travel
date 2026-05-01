@extends('layouts.admin')

@section('title', 'Payments')

@section('content')
@if (session('success'))
<div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
    {{ session('success') }}
</div>
@endif

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Payments</h1>
    <a href="{{ route('admin.payments.create') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700">Create Payment</a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-200" x-data="{ search: '{{ request('search') }}', timeout: null }">
        <form method="GET" action="{{ route('admin.payments.index') }}" id="search-form">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" :value="search" @input="search = $event.target.value; clearTimeout(timeout); timeout = setTimeout(() => document.getElementById('search-form').submit(), 300)" placeholder="Search payments..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">Search</button>
            @if (request('search') || request('status'))
            <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 text-gray-500 text-sm hover:text-gray-700">Clear</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Payment Ref</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Booking Ref</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Method</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Paid Date</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($payments as $payment)
                <tr class="hover:bg-gray-50 even:bg-gray-50/50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $payment->payment_ref }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $payment->booking?->booking_ref ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $payment->booking?->customer?->user?->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @php $typeColors = ['deposit' => 'bg-blue-100 text-blue-700', 'installment' => 'bg-purple-100 text-purple-700', 'full' => 'bg-emerald-100 text-emerald-700', 'refund' => 'bg-orange-100 text-orange-700']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $typeColors[$payment->type] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($payment->type) }}</span>
                    </td>
                    <td class="px-4 py-3 text-right font-medium text-gray-900">RM{{ number_format($payment->amount, 2) }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ str_replace('_', ' ', ucfirst($payment->method)) }}</td>
                    <td class="px-4 py-3">
                        @php $payStatusColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'verified' => 'bg-emerald-100 text-emerald-700', 'failed' => 'bg-red-100 text-red-700', 'refunded' => 'bg-orange-100 text-orange-700']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $payStatusColors[$payment->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($payment->status) }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $payment->paid_date?->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.payments.show', $payment) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg" title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @if ($payment->status === 'pending')
                            <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg" title="Verify">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-12 text-center text-gray-500">No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-4 py-3 border-t border-gray-200">
        {{ $payments->links() }}
    </div>
</div>
@endsection

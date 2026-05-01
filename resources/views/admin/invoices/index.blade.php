@extends('layouts.admin')

@section('title', 'Invoices')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Invoices</h1>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-200" x-data="{ search: '{{ request('search') }}', timeout: null }">
        <form method="GET" action="{{ route('admin.invoices.index') }}" id="search-form">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" :value="search" @input="search = $event.target.value; clearTimeout(timeout); timeout = setTimeout(() => document.getElementById('search-form').submit(), 300)" placeholder="Search invoices..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">Search</button>
            @if (request('search'))
            <a href="{{ route('admin.invoices.index') }}" class="px-4 py-2 text-gray-500 text-sm hover:text-gray-700">Clear</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Invoice No</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Booking Ref</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Issue Date</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Due Date</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($invoices as $invoice)
                <tr class="hover:bg-gray-50 even:bg-gray-50/50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $invoice->invoice_no }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $invoice->booking?->booking_ref ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $invoice->booking?->customer?->user?->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-right font-medium text-gray-900">RM{{ number_format($invoice->total, 2) }}</td>
                    <td class="px-4 py-3">
                        @php $invColors = ['draft' => 'bg-gray-100 text-gray-700', 'sent' => 'bg-blue-100 text-blue-700', 'paid' => 'bg-emerald-100 text-emerald-700', 'overdue' => 'bg-red-100 text-red-700', 'cancelled' => 'bg-gray-100 text-gray-500']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $invColors[$invoice->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($invoice->status) }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $invoice->issue_date?->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $invoice->due_date?->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg" title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('admin.invoices.download', $invoice) }}" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg" title="Download PDF">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-12 text-center text-gray-500">No invoices found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-4 py-3 border-t border-gray-200">
        {{ $invoices->links() }}
    </div>
</div>
@endsection

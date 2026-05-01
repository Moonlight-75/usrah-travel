@extends('layouts.admin')

@section('title', 'Invoice Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.invoices.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Invoices</a>
</div>

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Invoice {{ $invoice->invoice_no }}</h1>
    <a href="{{ route('admin.invoices.download', $invoice) }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 inline-flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Download PDF
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Invoice Info</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Invoice No</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $invoice->invoice_no }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd class="mt-1">
                        @php $invColors = ['draft' => 'bg-gray-100 text-gray-700', 'sent' => 'bg-blue-100 text-blue-700', 'paid' => 'bg-emerald-100 text-emerald-700', 'overdue' => 'bg-red-100 text-red-700', 'cancelled' => 'bg-gray-100 text-gray-500']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $invColors[$invoice->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($invoice->status) }}</span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Issue Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $invoice->issue_date?->format('d M Y') ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Due Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $invoice->due_date?->format('d M Y') ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Paid Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $invoice->paid_date?->format('d M Y') ?? '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Customer & Booking</h2>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase mb-2">Customer</h3>
                    <p class="text-sm font-medium text-gray-900">{{ $invoice->booking?->customer?->user?->name ?? '-' }}</p>
                    <p class="text-sm text-gray-600">{{ $invoice->booking?->customer?->user?->email ?? '-' }}</p>
                    <p class="text-sm text-gray-600">{{ $invoice->booking?->customer?->user?->phone ?? '' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase mb-2">Booking</h3>
                    <p class="text-sm"><a href="{{ route('admin.bookings.show', $invoice->booking) }}" class="font-medium text-emerald-600 hover:text-emerald-700">{{ $invoice->booking?->booking_ref }}</a></p>
                    <p class="text-sm text-gray-600">{{ $invoice->booking?->package?->name ?? '-' }}</p>
                    <p class="text-sm text-gray-600">{{ $invoice->booking?->travel_date?->format('d M Y') }} — {{ $invoice->booking?->return_date?->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Invoice Summary</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Subtotal</span>
                    <span class="text-sm text-gray-900">RM{{ number_format($invoice->subtotal, 2) }}</span>
                </div>
                @if ($invoice->tax > 0)
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Tax</span>
                    <span class="text-sm text-gray-900">RM{{ number_format($invoice->tax, 2) }}</span>
                </div>
                @endif
                @if ($invoice->discount > 0)
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Discount</span>
                    <span class="text-sm text-red-600">-RM{{ number_format($invoice->discount, 2) }}</span>
                </div>
                @endif
                <div class="pt-3 border-t border-gray-200 flex justify-between">
                    <span class="text-base font-semibold text-gray-900">Total</span>
                    <span class="text-base font-bold text-gray-900">RM{{ number_format($invoice->total, 2) }}</span>
                </div>
            </div>
        </div>

        @if ($invoice->notes)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Notes</h2>
            <p class="text-sm text-gray-700">{{ $invoice->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection

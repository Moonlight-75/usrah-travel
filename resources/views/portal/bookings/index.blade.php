@extends('layouts.portal')

@section('title', 'My Bookings')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">My Bookings</h1>
    <p class="text-gray-500 mt-1">View and manage all your travel bookings.</p>
</div>

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-4 sm:p-6 border-b border-gray-200" x-data="{ search: '{{ request('search') ?? '' }}' }">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text"
                       x-model="search"
                       x-init="$watch('search', val => { clearTimeout(window._searchTimeout); window._searchTimeout = setTimeout(() => { window.location.href = '{{ route('portal.bookings.index') }}?search=' + encodeURIComponent(val); }, 300); })"
                       placeholder="Search by reference or package..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="flex items-center gap-2">
                <select onchange="window.location.href = '{{ route('portal.bookings.index') }}?status=' + this.value"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All Statuses</option>
                    <option value="inquiry" {{ request('status') === 'inquiry' ? 'selected' : '' }}>Inquiry</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="deposit_paid" {{ request('status') === 'deposit_paid' ? 'selected' : '' }}>Deposit Paid</option>
                    <option value="fully_paid" {{ request('status') === 'fully_paid' ? 'selected' : '' }}>Fully Paid</option>
                    <option value="visa_processing" {{ request('status') === 'visa_processing' ? 'selected' : '' }}>Visa Processing</option>
                    <option value="visa_approved" {{ request('status') === 'visa_approved' ? 'selected' : '' }}>Visa Approved</option>
                    <option value="departed" {{ request('status') === 'departed' ? 'selected' : '' }}>Departed</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>
    </div>

    @if($bookings->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pax</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Travel Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-50 {{ $loop->even ? 'bg-gray-50/50' : '' }}">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $booking->booking_ref }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $booking->package?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $booking->pax_adults }}{{ $booking->pax_children ? '+' . $booking->pax_children : '' }}</td>
                            <td class="px-4 py-3 text-sm">
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
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $booking->travel_date?->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">RM {{ number_format($booking->total_amount, 2) }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-green-600">RM {{ number_format($booking->paid_amount, 2) }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('portal.bookings.show', $booking->id) }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
            <p class="text-sm text-gray-500">Showing {{ $bookings->firstItem() ?? 0 }}-{{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }}</p>
            {{ $bookings->links() }}
        </div>
    @else
        <div class="text-center py-12 text-gray-400 text-sm">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            No bookings found.
        </div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-500 mt-1">Welcome back, {{ Auth::user()->name }}.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalBookings) }}</p>
                <p class="text-sm text-gray-500">{{ number_format($activeBookings) }} active</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-bold text-gray-900">RM {{ number_format($totalRevenue, 2) }}</p>
                <p class="text-sm text-gray-500">from verified payments</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalCustomers) }}</p>
                <p class="text-sm text-gray-500">registered customers</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <div class="flex items-center gap-2">
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($pendingPayments) }}</p>
                    @if($pendingPayments > 0)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">{{ $pendingPayments }}</span>
                    @endif
                </div>
                <p class="text-sm text-gray-500">pending payments</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Monthly Bookings</h2>
        @if($monthlyBookings->count() > 0)
            <div class="flex items-end justify-between gap-2 h-48">
                @php
                    $maxCount = $monthlyBookings->max() ?: 1;
                @endphp
                @foreach($monthlyBookings as $month => $count)
                    <div class="flex-1 flex flex-col items-center justify-end h-full">
                        <span class="text-xs font-medium text-gray-700 mb-1">{{ $count }}</span>
                        <div class="w-full bg-emerald-500 rounded-t-sm transition-all duration-300"
                             style="height: {{ ($count / $maxCount) * 100 }}%; min-height: 4px;"></div>
                        <span class="text-xs text-gray-500 mt-2 whitespace-nowrap">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M') }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-48 text-gray-400 text-sm">No booking data yet.</div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Booking Status Distribution</h2>
        @if($bookingStatuses->count() > 0)
            @php
                $statusColors = [
                    'inquiry' => 'bg-gray-400',
                    'confirmed' => 'bg-blue-500',
                    'deposit_paid' => 'bg-yellow-500',
                    'fully_paid' => 'bg-green-500',
                    'visa_processing' => 'bg-purple-500',
                    'visa_approved' => 'bg-indigo-500',
                    'departed' => 'bg-emerald-500',
                    'completed' => 'bg-green-700',
                    'cancelled' => 'bg-red-500',
                ];
                $maxStatusCount = $bookingStatuses->max() ?: 1;
            @endphp
            <div class="space-y-3">
                @foreach($bookingStatuses as $status => $count)
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-medium text-gray-600 w-32 truncate" title="{{ $status }}">
                            {{ str_replace('_', ' ', ucfirst($status)) }}
                        </span>
                        <div class="flex-1 bg-gray-100 rounded-full h-5 overflow-hidden">
                            <div class="h-full rounded-full {{ $statusColors[$status] ?? 'bg-gray-400' }} transition-all duration-300"
                                 style="width: {{ ($count / $maxStatusCount) * 100 }}%; min-width: 20px;"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-700 w-8 text-right">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-48 text-gray-400 text-sm">No booking data yet.</div>
        @endif
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Recent Bookings</h2>
        <a href="{{ route('admin.bookings.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">View All</a>
    </div>
    @if($recentBookings->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ref</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pax</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Travel Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentBookings as $booking)
                        <tr class="hover:bg-gray-50 {{ $loop->even ? 'bg-gray-50/50' : '' }}">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $booking->booking_ref }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $booking->customer?->user?->name ?? '—' }}</td>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 text-gray-400 text-sm">No bookings yet.</div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Upcoming Tours</h2>
            <a href="{{ route('admin.tours.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">View All</a>
        </div>
        @if($upcomingTours->count() > 0)
            <div class="space-y-4">
                @foreach($upcomingTours as $tour)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $tour->package?->name ?? '—' }}</p>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-xs text-gray-500">{{ $tour->customer?->user?->name ?? '—' }}</span>
                                <span class="text-xs text-gray-400">|</span>
                                <span class="text-xs text-gray-500">{{ $tour->travel_date?->format('d M Y') }}</span>
                                <span class="text-xs text-gray-400">|</span>
                                <span class="text-xs text-gray-500">{{ $tour->pax_adults }} pax</span>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-3 flex-shrink-0">
                            {{ $tour->travel_date?->diffForHumans() }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-400 text-sm">No upcoming tours.</div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('admin.bookings.create') }}"
               class="flex items-center gap-3 p-4 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition-colors group">
                <svg class="w-5 h-5 text-emerald-600 group-hover:text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span class="text-sm font-medium text-emerald-700">New Booking</span>
            </a>

            <a href="{{ route('admin.packages.create') }}"
               class="flex items-center gap-3 p-4 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors group">
                <svg class="w-5 h-5 text-blue-600 group-hover:text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span class="text-sm font-medium text-blue-700">Add Package</span>
            </a>

            <a href="{{ route('admin.contacts.index') }}"
               class="flex items-center gap-3 p-4 rounded-lg bg-purple-50 hover:bg-purple-100 transition-colors group relative">
                <svg class="w-5 h-5 text-purple-600 group-hover:text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="text-sm font-medium text-purple-700">View Contacts</span>
                @if($newContacts > 0)
                    <span class="absolute top-2 right-2 inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-500 text-white text-xs font-bold">{{ $newContacts }}</span>
                @endif
            </a>

            <a href="{{ route('admin.payments.index') }}"
               class="flex items-center gap-3 p-4 rounded-lg bg-amber-50 hover:bg-amber-100 transition-colors group relative">
                <svg class="w-5 h-5 text-amber-600 group-hover:text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="text-sm font-medium text-amber-700">View Payments</span>
                @if($pendingPayments > 0)
                    <span class="absolute top-2 right-2 inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-500 text-white text-xs font-bold">{{ $pendingPayments }}</span>
                @endif
            </a>
        </div>
    </div>
</div>
@endsection

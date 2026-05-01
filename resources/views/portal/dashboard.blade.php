@extends('layouts.portal')

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
                <p class="text-2xl font-bold text-gray-900">{{ $totalBookings }}</p>
                <p class="text-sm text-gray-500">{{ $activeBookings }} active</p>
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
                <p class="text-2xl font-bold text-gray-900">RM {{ number_format($totalSpent, 2) }}</p>
                <p class="text-sm text-gray-500">total spent</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-bold text-gray-900">{{ $activeBookings }}</p>
                <p class="text-sm text-gray-500">upcoming trips</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <div class="flex items-center gap-2">
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingDocuments }}</p>
                    @if($pendingDocuments > 0)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">review</span>
                    @endif
                </div>
                <p class="text-sm text-gray-500">pending documents</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Upcoming Trips</h2>
            <a href="{{ route('portal.bookings.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">View All</a>
        </div>
        @if($upcomingBookings->count() > 0)
            <div class="space-y-4">
                @foreach($upcomingBookings as $booking)
                    <a href="{{ route('portal.bookings.show', $booking->id) }}" class="block p-4 bg-gray-50 rounded-lg hover:bg-emerald-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $booking->package?->name ?? '—' }}</p>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-gray-500">{{ $booking->travel_date?->format('d M Y') }}</span>
                                    <span class="text-xs text-gray-400">|</span>
                                    <span class="text-xs text-gray-500">{{ $booking->pax_adults }}{{ $booking->pax_children ? '+' . $booking->pax_children : '' }} pax</span>
                                    <span class="text-xs text-gray-400">|</span>
                                    <span class="text-xs text-gray-500">RM {{ number_format($booking->total_amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="ml-3 flex-shrink-0">
                                @php
                                    $badgeColors = [
                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                        'deposit_paid' => 'bg-yellow-100 text-yellow-800',
                                        'fully_paid' => 'bg-green-100 text-green-800',
                                        'visa_processing' => 'bg-purple-100 text-purple-800',
                                        'visa_approved' => 'bg-indigo-100 text-indigo-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-emerald-600 font-medium">
                            {{ $booking->travel_date?->diffForHumans() }}
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-400 text-sm">No upcoming trips.</div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('portal.bookings.index') }}"
               class="flex items-center gap-3 p-4 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition-colors group">
                <svg class="w-5 h-5 text-emerald-600 group-hover:text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="text-sm font-medium text-emerald-700">My Bookings</span>
            </a>

            <a href="{{ route('portal.documents.index') }}"
               class="flex items-center gap-3 p-4 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors group">
                <svg class="w-5 h-5 text-blue-600 group-hover:text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <span class="text-sm font-medium text-blue-700">Upload Doc</span>
            </a>

            <a href="{{ route('portal.payments.index') }}"
               class="flex items-center gap-3 p-4 rounded-lg bg-amber-50 hover:bg-amber-100 transition-colors group">
                <svg class="w-5 h-5 text-amber-600 group-hover:text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="text-sm font-medium text-amber-700">Payments</span>
            </a>

            <a href="{{ route('portal.profile') }}"
               class="flex items-center gap-3 p-4 rounded-lg bg-purple-50 hover:bg-purple-100 transition-colors group">
                <svg class="w-5 h-5 text-purple-600 group-hover:text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="text-sm font-medium text-purple-700">My Profile</span>
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Recent Bookings</h2>
        <a href="{{ route('portal.bookings.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">View All</a>
    </div>
    @if($recentBookings->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ref</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pax</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Travel Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentBookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('portal.bookings.show', $booking->id) }}" class="font-medium text-emerald-600 hover:text-emerald-700">{{ $booking->booking_ref }}</a>
                            </td>
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
@endsection

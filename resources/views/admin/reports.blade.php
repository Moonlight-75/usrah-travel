@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Reports</h1>
        <p class="text-gray-500 mt-1">Business analytics and performance overview.</p>
    </div>
    <div class="flex items-center gap-2">
        <select id="periodSelect" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            <option value="last_3_months" {{ $period === 'last_3_months' ? 'selected' : '' }}>Last 3 Months</option>
            <option value="last_6_months" {{ $period === 'last_6_months' ? 'selected' : '' }}>Last 6 Months</option>
            <option value="this_year" {{ $period === 'this_year' ? 'selected' : '' }}>This Year</option>
            <option value="last_year" {{ $period === 'last_year' ? 'selected' : '' }}>Last Year</option>
        </select>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-bold text-gray-900">RM {{ number_format($totalRevenue, 0) }}</p>
                <p class="text-sm text-gray-500">total revenue</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-bold text-gray-900">{{ $totalBookings }}</p>
                <p class="text-sm text-gray-500">bookings</p>
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
                <p class="text-2xl font-bold text-gray-900">{{ $activeCustomers }}</p>
                <p class="text-sm text-gray-500">active customers</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-bold text-gray-900">RM {{ number_format($avgBookingValue, 0) }}</p>
                <p class="text-sm text-gray-500">avg booking value</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Monthly Revenue</h2>
        @php $maxRevenue = collect($revenueChartData)->max('value') ?: 1; @endphp
        @if(collect($revenueChartData)->max('value') > 0)
            <div class="flex items-end justify-between gap-2 h-48">
                @foreach($revenueChartData as $item)
                    <div class="flex-1 flex flex-col items-center justify-end h-full">
                        <span class="text-xs font-medium text-gray-700 mb-1">RM{{ number_format($item['value'] / 1000, 1) }}k</span>
                        <div class="w-full bg-emerald-500 rounded-t-sm transition-all duration-300"
                             style="height: {{ ($item['value'] / $maxRevenue) * 100 }}%; min-height: 4px;"></div>
                        <span class="text-xs text-gray-500 mt-2">{{ $item['month'] }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-48 text-gray-400 text-sm">No revenue data for this period.</div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Monthly Bookings</h2>
        @php $maxBookings = collect($bookingChartData)->max('value') ?: 1; @endphp
        @if(collect($bookingChartData)->max('value') > 0)
            <div class="flex items-end justify-between gap-2 h-48">
                @foreach($bookingChartData as $item)
                    <div class="flex-1 flex flex-col items-center justify-end h-full">
                        <span class="text-xs font-medium text-gray-700 mb-1">{{ $item['value'] }}</span>
                        <div class="w-full bg-blue-500 rounded-t-sm transition-all duration-300"
                             style="height: {{ ($item['value'] / $maxBookings) * 100 }}%; min-height: 4px;"></div>
                        <span class="text-xs text-gray-500 mt-2">{{ $item['month'] }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-48 text-gray-400 text-sm">No booking data for this period.</div>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Booking Status</h2>
        @if($bookingStatuses->count() > 0)
            @php
                $statusColors = [
                    'inquiry' => 'bg-gray-400', 'confirmed' => 'bg-blue-500', 'deposit_paid' => 'bg-yellow-500',
                    'fully_paid' => 'bg-green-500', 'visa_processing' => 'bg-purple-500', 'visa_approved' => 'bg-indigo-500',
                    'departed' => 'bg-emerald-500', 'completed' => 'bg-green-700', 'cancelled' => 'bg-red-500',
                ];
                $maxStatus = $bookingStatuses->max() ?: 1;
            @endphp
            <div class="space-y-3">
                @foreach($bookingStatuses as $status => $count)
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-medium text-gray-600 w-28 truncate" title="{{ $status }}">
                            {{ str_replace('_', ' ', ucfirst($status)) }}
                        </span>
                        <div class="flex-1 bg-gray-100 rounded-full h-5 overflow-hidden">
                            <div class="h-full rounded-full {{ $statusColors[$status] ?? 'bg-gray-400' }} transition-all duration-300"
                                 style="width: {{ ($count / $maxStatus) * 100 }}%; min-width: 20px;"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-700 w-8 text-right">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-48 text-gray-400 text-sm">No data.</div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Methods</h2>
        @if($paymentMethods->count() > 0)
            @php
                $methodIcons = ['bank_transfer' => '🏦', 'online' => '💳', 'cash' => '💵', 'cheque' => '📄'];
                $methodTotal = $paymentMethods->sum('total') ?: 1;
            @endphp
            <div class="space-y-4">
                @foreach($paymentMethods as $pm)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $pm->method)) }}</span>
                            <div class="text-right">
                                <span class="text-sm font-bold text-gray-900">RM {{ number_format($pm->total, 0) }}</span>
                                <span class="text-xs text-gray-400 ml-1">({{ $pm->count }} txns)</span>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded-full h-2.5 overflow-hidden">
                            <div class="h-full rounded-full bg-emerald-500 transition-all duration-300"
                                 style="width: {{ ($pm->total / $methodTotal) * 100 }}%; min-width: 8px;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-48 text-gray-400 text-sm">No payment data.</div>
        @endif

        @if($pendingPaymentsCount > 0 || $rejectedPaymentsCount > 0)
            <div class="mt-4 pt-4 border-t border-gray-100 space-y-2">
                @if($pendingPaymentsCount > 0)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-amber-600 font-medium">Pending Verification</span>
                        <span class="text-amber-700 font-bold">{{ $pendingPaymentsCount }} (RM {{ number_format($pendingPaymentsAmount, 0) }})</span>
                    </div>
                @endif
                @if($rejectedPaymentsCount > 0)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-red-600 font-medium">Rejected</span>
                        <span class="text-red-700 font-bold">{{ $rejectedPaymentsCount }}</span>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Document Status</h2>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-green-800">Approved</span>
                </div>
                <div class="text-right">
                    <span class="text-sm font-bold text-green-900">{{ $approvedDocuments }}</span>
                    @if($totalDocuments > 0)
                        <span class="text-xs text-green-600 ml-1">{{ round(($approvedDocuments / $totalDocuments) * 100) }}%</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                    <span class="text-sm font-medium text-amber-800">Pending Review</span>
                </div>
                <div class="text-right">
                    <span class="text-sm font-bold text-amber-900">{{ $pendingDocuments }}</span>
                    @if($totalDocuments > 0)
                        <span class="text-xs text-amber-600 ml-1">{{ round(($pendingDocuments / $totalDocuments) * 100) }}%</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                    <span class="text-sm font-medium text-red-800">Rejected</span>
                </div>
                <div class="text-right">
                    <span class="text-sm font-bold text-red-900">{{ $rejectedDocuments }}</span>
                    @if($totalDocuments > 0)
                        <span class="text-xs text-red-600 ml-1">{{ round(($rejectedDocuments / $totalDocuments) * 100) }}%</span>
                    @endif
                </div>
            </div>
            <div class="pt-2 border-t border-gray-100">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Total Documents</span>
                    <span class="font-bold text-gray-900">{{ $totalDocuments }}</span>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500">New Contacts</span>
                <span class="font-medium text-gray-700">{{ $newContacts }}</span>
            </div>
            @if($unreadContacts > 0)
                <div class="flex items-center justify-between text-sm mt-2">
                    <span class="text-amber-600 font-medium">Unread Messages</span>
                    <span class="font-bold text-amber-700">{{ $unreadContacts }}</span>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Top Packages by Revenue</h2>
        @if($topPackages->count() > 0)
            @php $maxPkgRevenue = $topPackages->max('bookings_sum_total_amount') ?: 1; @endphp
            <div class="space-y-4">
                @foreach($topPackages as $pkg)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700 truncate max-w-[200px]" title="{{ $pkg->name }}">{{ $pkg->name }}</span>
                            <div class="text-right flex-shrink-0 ml-3">
                                <span class="text-sm font-bold text-gray-900">RM {{ number_format($pkg->bookings_sum_total_amount, 0) }}</span>
                                <span class="text-xs text-gray-400 ml-1">{{ $pkg->bookings_count }} bookings</span>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div class="h-full rounded-full bg-emerald-500 transition-all duration-300"
                                 style="width: {{ ($pkg->bookings_sum_total_amount / $maxPkgRevenue) * 100 }}%; min-width: 8px;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-48 text-gray-400 text-sm">No data for this period.</div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Customer Growth</h2>
        @php $maxCust = collect($customerChartData)->max('value') ?: 1; @endphp
        @if(collect($customerChartData)->max('value') > 0)
            <div class="flex items-end justify-between gap-2 h-48">
                @foreach($customerChartData as $item)
                    <div class="flex-1 flex flex-col items-center justify-end h-full">
                        <span class="text-xs font-medium text-gray-700 mb-1">{{ $item['value'] }}</span>
                        <div class="w-full bg-indigo-500 rounded-t-sm transition-all duration-300"
                             style="height: {{ ($item['value'] / $maxCust) * 100 }}%; min-height: 4px;"></div>
                        <span class="text-xs text-gray-500 mt-2">{{ $item['month'] }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-48 text-gray-400 text-sm">No data for this period.</div>
        @endif
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Latest Bookings</h2>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentBookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-emerald-600">{{ $booking->booking_ref }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $booking->customer?->user?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $booking->package?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $booking->pax_adults }}</td>
                            <td class="px-4 py-3 text-sm">
                                @php
                                    $badgeColors = [
                                        'inquiry' => 'bg-gray-100 text-gray-800', 'confirmed' => 'bg-blue-100 text-blue-800',
                                        'deposit_paid' => 'bg-yellow-100 text-yellow-800', 'fully_paid' => 'bg-green-100 text-green-800',
                                        'visa_processing' => 'bg-purple-100 text-purple-800', 'visa_approved' => 'bg-indigo-100 text-indigo-800',
                                        'departed' => 'bg-emerald-100 text-emerald-800', 'completed' => 'bg-green-200 text-green-900',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">RM {{ number_format($booking->total_amount, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $booking->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 text-gray-400 text-sm">No bookings yet.</div>
    @endif
</div>

<script>
    document.getElementById('periodSelect').addEventListener('change', function() {
        window.location.href = '{{ route("admin.reports") }}?period=' + this.value;
    });
</script>
@endsection

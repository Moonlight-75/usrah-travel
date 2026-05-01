@extends('layouts.admin')

@section('title', 'Customer Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.customers.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Customers</a>
</div>

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">{{ $customer->user?->name ?? 'Unknown' }}</h1>
    <a href="{{ route('admin.customers.edit', $customer) }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700">Edit</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Full Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->user?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->user?->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Phone</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->user?->phone ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">IC/Passport No</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->ic_passport_no ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">IC/Passport Expiry</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->ic_passport_expiry ? $customer->ic_passport_expiry->format('d M Y') : '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Address</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Address</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->address ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">City</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->city ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">State</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->state ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Postcode</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->postcode ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Country</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->country ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Emergency Contact</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->emergency_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Phone</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->emergency_phone ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Relation</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->emergency_relation ?? '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Bookings ({{ $customer->bookings->count() }})</h2>
            </div>
            @if ($customer->bookings->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Ref</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Package</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Travel Date</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($customer->bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $booking->booking_ref }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $booking->package?->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'inquiry' => 'bg-gray-100 text-gray-700',
                                        'confirmed' => 'bg-blue-100 text-blue-700',
                                        'deposit_paid' => 'bg-cyan-100 text-cyan-700',
                                        'fully_paid' => 'bg-emerald-100 text-emerald-700',
                                        'visa_processing' => 'bg-yellow-100 text-yellow-700',
                                        'visa_approved' => 'bg-emerald-100 text-emerald-700',
                                        'visa_rejected' => 'bg-red-100 text-red-700',
                                        'departed' => 'bg-indigo-100 text-indigo-700',
                                        'completed' => 'bg-emerald-100 text-emerald-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        'refunded' => 'bg-orange-100 text-orange-700',
                                    ];
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-700' }}">{{ str_replace('_', ' ', ucfirst($booking->status)) }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $booking->travel_date?->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right font-medium text-gray-900">RM{{ number_format($booking->total_amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-6 text-center text-gray-500">No bookings yet.</div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Documents ({{ $customer->documents->count() }})</h2>
            </div>
            @if ($customer->documents->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">File</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Uploaded</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($customer->documents as $doc)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-900">{{ ucfirst($doc->type) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $doc->file_name }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $docStatusColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'approved' => 'bg-emerald-100 text-emerald-700', 'rejected' => 'bg-red-100 text-red-700'];
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $docStatusColors[$doc->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($doc->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $doc->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-6 text-center text-gray-500">No documents uploaded.</div>
            @endif
        </div>
    </div>
</div>
@endsection

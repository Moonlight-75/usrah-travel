@extends('layouts.admin')

@section('title', 'Vendor Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.vendors.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Vendors</a>
</div>

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">{{ $vendor->name }}</h1>
    <a href="{{ route('admin.vendors.edit', $vendor) }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700">Edit</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Vendor Info</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Type</dt>
                    <dd class="mt-1">
                        @php
                            $vendorTypeColors = ['hotel' => 'bg-blue-100 text-blue-700', 'transport' => 'bg-purple-100 text-purple-700', 'mutawwif' => 'bg-emerald-100 text-emerald-700', 'airline' => 'bg-indigo-100 text-indigo-700', 'insurance' => 'bg-amber-100 text-amber-700', 'visa_agent' => 'bg-cyan-100 text-cyan-700', 'other' => 'bg-gray-100 text-gray-700'];
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $vendorTypeColors[$vendor->type] ?? 'bg-gray-100 text-gray-700' }}">{{ str_replace('_', ' ', ucfirst($vendor->type)) }}</span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Contact Person</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $vendor->contact_person ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $vendor->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Phone</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $vendor->phone ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Rating</dt>
                    <dd class="mt-1">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($vendor->rating ?? 0))
                            <span class="text-amber-400">&starf;</span>
                            @else
                            <span class="text-gray-300">&starf;</span>
                            @endif
                        @endfor
                        <span class="text-sm text-gray-600 ml-1">{{ number_format($vendor->rating ?? 0, 1) }}</span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd class="mt-1">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $vendor->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $vendor->is_active ? 'Active' : 'Inactive' }}</span>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Address</h2>
            <div class="space-y-2">
                <p class="text-sm text-gray-900">{{ $vendor->address ?? '-' }}</p>
                <p class="text-sm text-gray-600">{{ $vendor->city ?? '' }}, {{ $vendor->country ?? '' }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Bank Details</h2>
            <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Bank Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $vendor->bank_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Account No</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $vendor->bank_account_no ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Account Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $vendor->bank_account_name ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        @if ($vendor->contract_details)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Contract Details</h2>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $vendor->contract_details }}</p>
        </div>
        @endif

        @if ($vendor->notes)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Notes</h2>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $vendor->notes }}</p>
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Tour Groups ({{ $vendor->tourGroups->count() }})</h2>
            </div>
            @if ($vendor->tourGroups->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Departure Date</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Pax</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($vendor->tourGroups as $tg)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $tg->name ?? $tg->id }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $tg->departure_date?->format('d M Y') ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $tg->pax ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-6 text-center text-gray-500">No tour groups assigned.</div>
            @endif
        </div>
    </div>
</div>
@endsection

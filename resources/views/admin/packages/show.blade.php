@extends('layouts.admin')

@section('title', 'Package Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.packages.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Packages</a>
</div>

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">{{ $package->name }}</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.packages.edit', $package) }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700">Edit</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Package Information</h2>
            <div class="space-y-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Category</dt>
                    <dd class="mt-1">
                        @php
                            $colors = ['umrah' => 'bg-emerald-100 text-emerald-700', 'halal_tour' => 'bg-blue-100 text-blue-700', 'corporate' => 'bg-purple-100 text-purple-700'];
                            $label = str_replace('_', ' ', ucfirst($package->category));
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$package->category] ?? 'bg-gray-100 text-gray-700' }}">{{ $label }}</span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Slug</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $package->slug }}</dd>
                </div>
                @if ($package->description)
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Description</dt>
                    <dd class="mt-1 text-sm text-gray-700 whitespace-pre-line">{{ $package->description }}</dd>
                </div>
                @endif
                @if ($package->terms)
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Terms & Conditions</dt>
                    <dd class="mt-1 text-sm text-gray-700 whitespace-pre-line">{{ $package->terms }}</dd>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Inclusions & Exclusions</h2>
            @if ($package->includes && is_array($package->includes) && count($package->includes))
            <div class="mb-4">
                <dt class="text-xs font-medium text-gray-500 uppercase mb-2">Includes</dt>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($package->includes as $item)
                    <li class="text-sm text-gray-700">{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if ($package->excludes && is_array($package->excludes) && count($package->excludes))
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase mb-2">Excludes</dt>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($package->excludes as $item)
                    <li class="text-sm text-gray-700">{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Details</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Duration</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $package->duration_days }} Days / {{ $package->duration_nights }} Nights</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Max Pax</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $package->max_pax }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Price</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">RM{{ number_format($package->price, 2) }}</dd>
                </div>
                @if ($package->discount_price)
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Discount Price</dt>
                    <dd class="mt-1 text-sm font-medium text-emerald-600">RM{{ number_format($package->discount_price, 2) }}</dd>
                </div>
                @endif
                <div class="pt-2 border-t border-gray-100">
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd class="mt-2 flex gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $package->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $package->is_active ? 'Active' : 'Inactive' }}</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $package->is_featured ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-500' }}">{{ $package->is_featured ? 'Featured' : 'Not Featured' }}</span>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Stats</h2>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Total Bookings</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $package->bookings()->count() }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Created</dt>
                    <dd class="text-sm text-gray-900">{{ $package->created_at->format('d M Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection

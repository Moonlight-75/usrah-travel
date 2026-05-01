@extends('layouts.public')

@section('title', $package->name)

@section('content')
<section class="bg-emerald-800 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm mb-6">
            <li class="flex items-center space-x-2 list-none">
                <a href="{{ route('home') }}" class="text-emerald-200 hover:text-white transition-colors duration-150">Home</a>
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </li>
            <li class="flex items-center space-x-2 list-none">
                <a href="{{ route('public.packages') }}" class="text-emerald-200 hover:text-white transition-colors duration-150">Packages</a>
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </li>
            <li class="text-white font-medium list-none">{{ $package->name }}</li>
        </nav>
        <div class="flex flex-col sm:flex-row items-start gap-4">
            @php
                $badgeColors = ['umrah' => 'bg-amber-500', 'halal_tour' => 'bg-blue-500', 'corporate' => 'bg-purple-500'];
                $badgeLabels = ['umrah' => 'Umrah', 'halal_tour' => 'Halal Tour', 'corporate' => 'Corporate'];
            @endphp
            <h1 class="text-3xl sm:text-4xl font-bold text-white">{{ $package->name }}</h1>
            <span class="{{ $badgeColors[$package->category] ?? 'bg-gray-500' }} text-white text-sm font-semibold px-4 py-1.5 rounded-full">{{ $badgeLabels[$package->category] ?? ucfirst($package->category) }}</span>
        </div>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-1 min-w-0">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                    <div class="h-64 sm:h-80 bg-gradient-to-br from-emerald-400 to-emerald-700 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">{{ $package->name }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
                    <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($package->description)) !!}
                    </div>
                </div>

                @if($package->itinerary && count($package->itinerary) > 0)
                <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Itinerary</h2>
                    <ol class="space-y-4">
                        @foreach($package->itinerary as $index => $day)
                            <li class="flex gap-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center font-bold text-sm">{{ $index + 1 }}</div>
                                <div class="flex-1 pt-1.5">
                                    <p class="text-gray-700 leading-relaxed">{{ $day }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    @if($package->includes && is_array($package->includes) && count($package->includes) > 0)
                    <div class="bg-white rounded-xl shadow-sm p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">What's Included</h2>
                        <ul class="space-y-3">
                            @foreach($package->includes as $item)
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-gray-700 text-sm">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($package->excludes && is_array($package->excludes) && count($package->excludes) > 0)
                    <div class="bg-white rounded-xl shadow-sm p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">What's Excluded</h2>
                        <ul class="space-y-3">
                            @foreach($package->excludes as $item)
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-red-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    <span class="text-gray-700 text-sm">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                @if($package->terms)
                <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Terms & Conditions</h2>
                    <div class="text-gray-700 text-sm leading-relaxed">
                        {!! nl2br(e($package->terms)) !!}
                    </div>
                </div>
                @endif
            </div>

            <div class="w-full lg:w-96 shrink-0">
                <div class="sticky top-24">
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="text-center mb-6">
                            <p class="text-sm text-gray-500 mb-1">Starting from</p>
                            @if($package->discount_price)
                                <div class="flex items-baseline justify-center gap-2">
                                    <span class="text-4xl font-bold text-emerald-600">RM {{ number_format((float) $package->discount_price, 0) }}</span>
                                </div>
                                <p class="text-gray-400 line-through text-sm">RM {{ number_format((float) $package->price, 0) }}</p>
                            @else
                                <span class="text-4xl font-bold text-emerald-600">RM {{ number_format((float) $package->price, 0) }}</span>
                            @endif
                            <p class="text-gray-500 text-sm mt-1">per person</p>
                        </div>

                        <div class="space-y-4 py-6 border-t border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 text-sm">Duration</span>
                                <span class="text-gray-900 font-semibold text-sm">{{ $package->duration_days }} Days {{ $package->duration_nights }} Nights</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 text-sm">Category</span>
                                <span class="text-gray-900 font-semibold text-sm">{{ $badgeLabels[$package->category] ?? ucfirst($package->category) }}</span>
                            </div>
                            @if($package->max_pax)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 text-sm">Max Pax</span>
                                <span class="text-gray-900 font-semibold text-sm">{{ $package->max_pax }} persons</span>
                            </div>
                            @endif
                        </div>

                        <div class="space-y-3 mt-6">
                            <a href="{{ route('register') }}" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors duration-200 shadow-md shadow-emerald-500/20">
                                Book Now
                            </a>
                            <a href="{{ route('public.contact') }}" class="block w-full text-center px-6 py-3 bg-emerald-50 text-emerald-700 font-semibold rounded-lg hover:bg-emerald-100 transition-colors duration-200">
                                Contact for Inquiry
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($relatedPackages->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Packages</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedPackages as $related)
                <a href="{{ route('public.packages.show', $related->slug) }}" class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group border border-gray-100">
                    <div class="h-40 bg-gradient-to-br from-emerald-400 to-emerald-700 flex items-center justify-center relative">
                        <span class="text-white font-bold z-10 px-4 text-center">{{ Str::limit($related->name, 25) }}</span>
                        <span class="absolute top-3 left-3 {{ $badgeColors[$related->category] ?? 'bg-gray-500' }} text-white text-xs font-semibold px-3 py-1 rounded-full z-10">{{ $badgeLabels[$related->category] ?? ucfirst($related->category) }}</span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-gray-900 mb-1">{{ $related->name }}</h3>
                        <p class="text-gray-500 text-sm mb-3">{{ $related->duration_days }}D{{ $related->duration_nights }}N</p>
                        <div class="flex items-baseline gap-2">
                            @if($related->discount_price)
                                <span class="text-lg font-bold text-emerald-600">RM {{ number_format((float) $related->discount_price, 0) }}</span>
                                <span class="text-xs text-gray-400 line-through">RM {{ number_format((float) $related->price, 0) }}</span>
                            @else
                                <span class="text-lg font-bold text-emerald-600">RM {{ number_format((float) $related->price, 0) }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

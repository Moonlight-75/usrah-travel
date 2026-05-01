@extends('layouts.public')

@section('title', 'Our Packages')

@section('content')
<section class="bg-emerald-800 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-white mb-4">Our Travel Packages</h1>
        <nav class="flex justify-center mt-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-emerald-200 hover:text-white transition-colors duration-150">Home</a></li>
                <li><svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li class="text-white font-medium">Packages</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div x-data="{ activeCategory: 'all', sortBy: 'newest' }" x-init="
            window.getFilteredPackages = () => {
                let filtered = packages.filter(p => activeCategory === 'all' || p.category === activeCategory);
                if (sortBy === 'price_low') filtered.sort((a, b) => parseFloat(a.price) - parseFloat(b.price));
                else if (sortBy === 'price_high') filtered.sort((a, b) => parseFloat(b.price) - parseFloat(a.price));
                else if (sortBy === 'duration') filtered.sort((a, b) => a.duration_days - b.duration_days);
                return filtered;
            };
        " x-init.defer>
            <script>
                window.packages = @json($packages);
            </script>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $key => $label)
                        <button @click="activeCategory = '{{ $key }}'" :class="activeCategory === '{{ $key }}' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-emerald-50 border border-gray-200'" class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200">{{ $label }}</button>
                    @endforeach
                </div>
                <div class="relative">
                    <select x-model="sortBy" class="appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2 pr-10 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer">
                        <option value="newest">Newest First</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="duration">Duration</option>
                    </select>
                    <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            <template x-for="pkg in getFilteredPackages()" :key="pkg.id">
                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group mb-6">
                    <div class="flex flex-col sm:flex-row">
                        <div class="sm:w-72 h-48 sm:h-auto bg-gradient-to-br from-emerald-400 to-emerald-700 flex items-center justify-center relative overflow-hidden shrink-0">
                            <span class="text-white text-lg font-bold z-10 px-4 text-center" x-text="pkg.name.length > 25 ? pkg.name.substring(0, 25) + '...' : pkg.name"></span>
                            <span class="absolute top-3 left-3 text-white text-xs font-semibold px-3 py-1 rounded-full z-10" :class="{
                                'bg-amber-500': pkg.category === 'umrah',
                                'bg-blue-500': pkg.category === 'halal_tour',
                                'bg-purple-500': pkg.category === 'corporate'
                            }" x-text="pkg.category === 'umrah' ? 'Umrah' : pkg.category === 'halal_tour' ? 'Halal Tour' : 'Corporate'"></span>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 mb-2" x-text="pkg.name"></h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2" x-text="pkg.description"></p>
                                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span x-text="pkg.duration_days + 'D ' + pkg.duration_nights + 'N'"></span>
                                    </span>
                                    <span class="flex items-center" x-show="pkg.max_pax">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span x-text="'Max ' + pkg.max_pax + ' pax'"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-baseline gap-2">
                                    <template x-if="pkg.discount_price">
                                        <span class="text-2xl font-bold text-emerald-600" x-text="'RM ' + parseFloat(pkg.discount_price).toLocaleString()"></span>
                                    </template>
                                    <template x-if="!pkg.discount_price">
                                        <span class="text-2xl font-bold text-emerald-600" x-text="'RM ' + parseFloat(pkg.price).toLocaleString()"></span>
                                    </template>
                                    <span class="text-sm text-gray-400 line-through" x-show="pkg.discount_price" x-text="'RM ' + parseFloat(pkg.price).toLocaleString()"></span>
                                    <span class="text-xs text-gray-400">/pax</span>
                                </div>
                                <a :href="'/packages/' + pkg.slug" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors duration-200 text-sm">
                                    View Details
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <div x-show="getFilteredPackages().length === 0" class="text-center py-16">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-gray-500 text-lg">No packages found for this category.</p>
                <p class="text-gray-400 text-sm mt-1">Try selecting a different category or contact us for custom packages.</p>
            </div>
        </div>
    </div>
</section>
@endsection

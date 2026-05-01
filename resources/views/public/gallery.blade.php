@extends('layouts.public')

@section('title', 'Gallery')

@section('content')
<section class="bg-emerald-800 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-white mb-4">Gallery</h1>
        <nav class="flex justify-center mt-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-emerald-200 hover:text-white transition-colors duration-150">Home</a></li>
                <li><svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li class="text-white font-medium">Gallery</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-12 bg-gray-50" x-data="{ activeFilter: 'all', lightboxOpen: false, lightboxTitle: '', lightboxGradient: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-2 mb-10">
            <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-emerald-50 border border-gray-200'" class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200">All</button>
            <button @click="activeFilter = 'umrah'" :class="activeFilter === 'umrah' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-emerald-50 border border-gray-200'" class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200">Umrah</button>
            <button @click="activeFilter = 'halal_tour'" :class="activeFilter === 'halal_tour' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-emerald-50 border border-gray-200'" class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200">Halal Tours</button>
            <button @click="activeFilter = 'corporate'" :class="activeFilter === 'corporate' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-emerald-50 border border-gray-200'" class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200">Corporate</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="item in [
                { title: 'Makkah Al-Mukarramah', category: 'umrah', gradient: 'from-emerald-500 to-emerald-800' },
                { title: 'Masjidil Haram at Night', category: 'umrah', gradient: 'from-emerald-700 to-emerald-900' },
                { title: 'Masjid Nabawi', category: 'umrah', gradient: 'from-emerald-400 to-teal-700' },
                { title: 'Jeddah Corniche', category: 'umrah', gradient: 'from-teal-500 to-emerald-700' },
                { title: 'Madinah City View', category: 'umrah', gradient: 'from-emerald-600 to-emerald-900' },
                { title: 'Kaabah Close-up', category: 'umrah', gradient: 'from-amber-500 to-emerald-700' },
                { title: 'Istanbul, Turkey', category: 'halal_tour', gradient: 'from-blue-500 to-emerald-700' },
                { title: 'Cappadocia, Turkey', category: 'halal_tour', gradient: 'from-blue-600 to-purple-700' },
                { title: 'Petra, Jordan', category: 'halal_tour', gradient: 'from-amber-600 to-orange-800' },
                { title: 'Dead Sea, Jordan', category: 'halal_tour', gradient: 'from-cyan-500 to-blue-700' },
                { title: 'Corporate Team Building', category: 'corporate', gradient: 'from-purple-500 to-indigo-700' },
                { title: 'Corporate Retreat', category: 'corporate', gradient: 'from-indigo-500 to-purple-800' }
            ].filter(i => activeFilter === 'all' || i.category === activeFilter)" :key="item.title">
                <button @click="lightboxOpen = true; lightboxTitle = item.title; lightboxGradient = item.gradient" class="block w-full group relative h-64 bg-gradient-to-br rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 cursor-pointer" :class="item.gradient">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                        <p class="text-white font-semibold text-sm" x-text="item.title"></p>
                    </div>
                </button>
            </template>
        </div>

        <div x-show="lightboxOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @keydown.escape.window="lightboxOpen = false">
            <div class="absolute inset-0 bg-black/80" @click="lightboxOpen = false"></div>
            <div class="relative z-10 w-full max-w-3xl" @click.stop>
                <div class="h-[60vh] bg-gradient-to-br rounded-2xl flex items-center justify-center" :class="lightboxGradient">
                    <p class="text-white text-3xl font-bold" x-text="lightboxTitle"></p>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <p class="text-white font-semibold text-lg" x-text="lightboxTitle"></p>
                    <button @click="lightboxOpen = false" class="text-white hover:text-gray-300 transition-colors duration-150">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

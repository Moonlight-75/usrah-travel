@extends('layouts.public')

@section('title', 'Home')

@section('content')
<section class="relative min-h-[600px] flex items-center justify-center overflow-hidden bg-emerald-900">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 via-emerald-700 to-emerald-900"></div>
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <p class="text-emerald-200 text-lg mb-6" dir="rtl" style="font-family: serif;">بسم الله الرحمن الرحيم</p>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">Your Trusted Partner for Umrah & Halal Travel</h1>
        <p class="text-lg sm:text-xl text-emerald-100 mb-10 max-w-3xl mx-auto leading-relaxed">Embark on a spiritually enriching journey with Usrah Travel & Tours. From Umrah packages to Halal holiday tours — we handle every detail so you can focus on what matters most.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('public.packages') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-emerald-500 text-white font-semibold rounded-lg hover:bg-emerald-400 transition-all duration-200 shadow-lg shadow-emerald-500/30">
                Explore Packages
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-8 py-3.5 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-emerald-800 transition-all duration-200">
                Contact Us
            </a>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 bg-emerald-800/60 backdrop-blur-sm">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <p class="text-2xl sm:text-3xl font-bold text-white">500+</p>
                    <p class="text-emerald-200 text-sm">Jemaah Served</p>
                </div>
                <div>
                    <p class="text-2xl sm:text-3xl font-bold text-white">50+</p>
                    <p class="text-emerald-200 text-sm">Tour Groups</p>
                </div>
                <div>
                    <p class="text-2xl sm:text-3xl font-bold text-white">10+</p>
                    <p class="text-emerald-200 text-sm">Years Experience</p>
                </div>
                <div>
                    <p class="text-2xl sm:text-3xl font-bold text-white">Licensed</p>
                    <p class="text-emerald-200 text-sm">by MOTAC</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Our Packages</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Discover our carefully curated travel packages designed to provide you with the best experience at competitive prices.</p>
        </div>

        <div x-data="{ activeTab: 'all' }" class="mb-10">
            <div class="flex flex-wrap justify-center gap-2">
                <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-emerald-50'" class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200">All</button>
                <button @click="activeTab = 'umrah'" :class="activeTab === 'umrah' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-emerald-50'" class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200">Umrah</button>
                <button @click="activeTab = 'halal_tour'" :class="activeTab === 'halal_tour' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-emerald-50'" class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200">Halal Tours</button>
                <button @click="activeTab = 'corporate'" :class="activeTab === 'corporate' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-emerald-50'" class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200">Corporate</button>
            </div>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredPackages as $package)
                    <div x-show="activeTab === 'all' || '{{ $package->category }}' === activeTab" class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                        <div class="h-48 bg-gradient-to-br from-emerald-400 to-emerald-700 flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-all duration-300"></div>
                            <span class="text-white text-xl font-bold z-10">{{ Str::limit($package->name, 30) }}</span>
                            @php
                                $badgeColors = ['umrah' => 'bg-amber-500', 'halal_tour' => 'bg-blue-500', 'corporate' => 'bg-purple-500'];
                                $badgeLabels = ['umrah' => 'Umrah', 'halal_tour' => 'Halal Tour', 'corporate' => 'Corporate'];
                            @endphp
                            <span class="absolute top-4 left-4 {{ $badgeColors[$package->category] ?? 'bg-gray-500' }} text-white text-xs font-semibold px-3 py-1 rounded-full z-10">{{ $badgeLabels[$package->category] ?? ucfirst($package->category) }}</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $package->name }}</h3>
                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $package->duration_days }}D{{ $package->duration_nights }}N
                            </div>
                            <div class="flex items-baseline gap-2 mb-4">
                                @if($package->discount_price)
                                    <span class="text-xl font-bold text-emerald-600">RM {{ number_format((float) $package->discount_price, 0) }}</span>
                                    <span class="text-sm text-gray-400 line-through">RM {{ number_format((float) $package->price, 0) }}</span>
                                @else
                                    <span class="text-xl font-bold text-emerald-600">RM {{ number_format((float) $package->price, 0) }}</span>
                                @endif
                                <span class="text-xs text-gray-400">/pax</span>
                            </div>
                            <a href="{{ route('public.packages.show', $package->slug) }}" class="block w-full text-center px-4 py-2.5 bg-emerald-50 text-emerald-700 font-semibold rounded-lg hover:bg-emerald-100 transition-colors duration-200">View Details</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <p class="text-gray-500 text-lg">No featured packages available at the moment.</p>
                        <p class="text-gray-400 text-sm mt-1">Please check back soon or contact us for custom packages.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Why Choose Us</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">We are committed to making your travel experience seamless, memorable, and spiritually fulfilling.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center p-6 rounded-xl bg-emerald-50/50 hover:bg-emerald-50 transition-colors duration-200">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Licensed & Trusted</h3>
                <p class="text-gray-600 text-sm leading-relaxed">MOTAC licensed agency with over 10 years of experience serving Malaysian jemaah with integrity and professionalism.</p>
            </div>
            <div class="text-center p-6 rounded-xl bg-emerald-50/50 hover:bg-emerald-50 transition-colors duration-200">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Complete Packages</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Flights, hotels, visa processing, ground transport, and meals — everything is arranged so you can travel worry-free.</p>
            </div>
            <div class="text-center p-6 rounded-xl bg-emerald-50/50 hover:bg-emerald-50 transition-colors duration-200">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Expert Guidance</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Experienced mutawwif and tour guides accompany you throughout your journey, ensuring a smooth and spiritually enriching experience.</p>
            </div>
            <div class="text-center p-6 rounded-xl bg-emerald-50/50 hover:bg-emerald-50 transition-colors duration-200">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">24/7 Support</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Dedicated support team available before, during, and after your trip. We are just a call or message away whenever you need us.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">What Our Jemaah Say</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Hear from those who have travelled with us and experienced the Usrah Travel difference.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-sm p-8 relative">
                <svg class="w-10 h-10 text-emerald-200 mb-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                <p class="text-gray-700 leading-relaxed mb-6">"Alhamdulillah, pengalaman Umrah yang sangat menyentuh hati. Usrah Travel sangat profesional dan prihatin."</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                        <span class="text-emerald-700 font-bold text-sm">AR</span>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold text-gray-900">Ahmad Razali</p>
                        <p class="text-gray-500 text-sm">Umrah Package 2024</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-8 relative">
                <svg class="w-10 h-10 text-emerald-200 mb-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                <p class="text-gray-700 leading-relaxed mb-6">"Pakej yang sangat berbaloi. Hotel berhampiran Masjidil Haram, mutawwif yang sangat berpengetahuan."</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                        <span class="text-emerald-700 font-bold text-sm">SA</span>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold text-gray-900">Siti Aminah</p>
                        <p class="text-gray-500 text-sm">Umrah Package 2025</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-8 relative">
                <svg class="w-10 h-10 text-emerald-200 mb-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                <p class="text-gray-700 leading-relaxed mb-6">"Servis yang cemerlang dari mula hingga akhir. Sangat recommend untuk keluarga!"</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                        <span class="text-emerald-700 font-bold text-sm">IY</span>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold text-gray-900">Ismail bin Yusof</p>
                        <p class="text-gray-500 text-sm">Family Umrah 2025</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-emerald-700">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Ready to begin your spiritual journey?</h2>
        <p class="text-emerald-100 text-lg mb-8 max-w-2xl mx-auto">Contact us today for a free consultation and customized package tailored to your needs and budget.</p>
        <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white text-emerald-700 font-semibold rounded-lg hover:bg-emerald-50 transition-all duration-200 shadow-lg">
            Get in Touch
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>
@endsection

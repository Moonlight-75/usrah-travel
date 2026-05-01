@extends('layouts.public')

@section('title', 'About Us')

@section('content')
<section class="bg-emerald-800 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-white mb-4">About Us</h1>
        <nav class="flex justify-center mt-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-emerald-200 hover:text-white transition-colors duration-150">Home</a></li>
                <li><svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li class="text-white font-medium">About Us</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">Our Story</h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p>Usrah Travel & Tours was established with a singular vision — to provide Malaysian Muslims with a reliable, trustworthy, and spiritually enriching travel experience for their Umrah and Halal holiday needs.</p>
                    <p>Founded by a team of passionate travel professionals with deep knowledge of the Holy Lands, we have grown from a small agency to one of the respected names in the Malaysian travel industry. Over the years, we have proudly served more than 500 jemaah, helping them fulfil their dream of visiting Makkah and Madinah.</p>
                    <p>Our name "Usrah" means family in Arabic, and that is exactly how we treat every traveller who walks through our doors. We believe that the journey of a lifetime deserves nothing less than a family's care and attention to detail.</p>
                </div>
            </div>
            <div class="h-80 bg-gradient-to-br from-emerald-400 to-emerald-700 rounded-2xl flex items-center justify-center">
                <div class="text-center text-white">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-2xl font-bold">Usrah Travel & Tours</p>
                    <p class="text-emerald-100 mt-1">Since 2010</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Our Mission & Vision</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm p-8 border-t-4 border-emerald-500">
                <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Our Mission</h3>
                <p class="text-gray-600 leading-relaxed">To deliver exceptional, hassle-free Umrah and Halal travel services that prioritise the spiritual well-being, comfort, and safety of every jemaah. We are committed to transparency, professionalism, and heartfelt service in every journey we facilitate.</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-8 border-t-4 border-emerald-500">
                <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Our Vision</h3>
                <p class="text-gray-600 leading-relaxed">To become the most trusted Umrah and Halal travel agency in Malaysia, recognised for our unwavering commitment to quality, our deep understanding of our clients' spiritual needs, and our ability to create journeys that transform lives.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-emerald-700">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <p class="text-4xl sm:text-5xl font-bold text-white mb-2">500+</p>
                <p class="text-emerald-200 text-sm font-medium">Jemaah Served</p>
            </div>
            <div>
                <p class="text-4xl sm:text-5xl font-bold text-white mb-2">50+</p>
                <p class="text-emerald-200 text-sm font-medium">Tour Groups</p>
            </div>
            <div>
                <p class="text-4xl sm:text-5xl font-bold text-white mb-2">10+</p>
                <p class="text-emerald-200 text-sm font-medium">Years Experience</p>
            </div>
            <div>
                <p class="text-4xl sm:text-5xl font-bold text-white mb-2">Licensed</p>
                <p class="text-emerald-200 text-sm font-medium">by MOTAC</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Our Services</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Comprehensive travel solutions tailored for your spiritual and leisure needs.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-emerald-50 rounded-xl p-6 text-center hover:bg-emerald-100 transition-colors duration-200">
                <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Umrah Packages</h3>
                <p class="text-gray-600 text-sm">Complete Umrah packages including flights, accommodation near Masjidil Haram, visa, and mutawwif guidance.</p>
            </div>
            <div class="bg-emerald-50 rounded-xl p-6 text-center hover:bg-emerald-100 transition-colors duration-200">
                <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Halal Tours</h3>
                <p class="text-gray-600 text-sm">Explore the world with our Halal-certified holiday packages to Turkey, Jordan, Morocco, and more.</p>
            </div>
            <div class="bg-emerald-50 rounded-xl p-6 text-center hover:bg-emerald-100 transition-colors duration-200">
                <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Corporate Travel</h3>
                <p class="text-gray-600 text-sm">Customised corporate travel solutions with group rates, dedicated account management, and flexible arrangements.</p>
            </div>
            <div class="bg-emerald-50 rounded-xl p-6 text-center hover:bg-emerald-100 transition-colors duration-200">
                <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Visa Assistance</h3>
                <p class="text-gray-600 text-sm">Hassle-free visa processing for Saudi Arabia and other destinations. We handle the paperwork so you don't have to.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">The dedicated people behind every successful journey.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full mx-auto mb-5 flex items-center justify-center">
                    <svg class="w-14 h-14 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Haji Mohd Farid</h3>
                <p class="text-emerald-600 text-sm font-medium">Director</p>
                <p class="text-gray-500 text-sm mt-2">15+ years in the travel industry with extensive experience in Umrah operations and pilgrim management.</p>
            </div>
            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full mx-auto mb-5 flex items-center justify-center">
                    <svg class="w-14 h-14 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Puan Nora Aida</h3>
                <p class="text-emerald-600 text-sm font-medium">Operations Manager</p>
                <p class="text-gray-500 text-sm mt-2">Expert in tour coordination, vendor management, and ensuring every trip runs smoothly from start to finish.</p>
            </div>
            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full mx-auto mb-5 flex items-center justify-center">
                    <svg class="w-14 h-14 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Encik Amirul</h3>
                <p class="text-emerald-600 text-sm font-medium">Customer Service Lead</p>
                <p class="text-gray-500 text-sm mt-2">Dedicated to providing exceptional support and guidance to every client throughout their travel journey.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-emerald-50 rounded-2xl p-10 border border-emerald-100">
            <div class="w-20 h-20 bg-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Licensed & Certified</h3>
            <p class="text-gray-600 max-w-lg mx-auto">Usrah Travel & Tours is a fully licensed travel agency registered with the Ministry of Tourism, Arts and Culture (MOTAC) Malaysia. We comply with all industry regulations and standards to ensure your peace of mind.</p>
            <div class="mt-6 inline-flex items-center px-6 py-2 bg-white rounded-full shadow-sm border border-emerald-200">
                <svg class="w-5 h-5 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-emerald-700 font-semibold text-sm">MOTAC Licensed Agency</span>
            </div>
        </div>
    </div>
</section>
@endsection

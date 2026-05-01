@extends('layouts.public')

@section('title', 'Contact Us')

@section('content')
<section class="bg-emerald-800 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-white mb-4">Contact Us</h1>
        <nav class="flex justify-center mt-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-emerald-200 hover:text-white transition-colors duration-150">Home</a></li>
                <li><svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li class="text-white font-medium">Contact</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Send Us a Message</h2>
                    <p class="text-gray-500 text-sm mb-8">Fill out the form below and we'll get back to you as soon as possible.</p>

                    <form method="POST" action="{{ route('public.contact.store') }}" x-data="{ subject: old('subject', '{{ old('subject') }}') }">
                        @csrf
                        <div class="space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition-colors duration-150" placeholder="Your full name">
                                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition-colors duration-150" placeholder="you@example.com">
                                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition-colors duration-150" placeholder="+6012-345 6789">
                                    @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1.5">Subject <span class="text-red-500">*</span></label>
                                    <select id="subject" name="subject" x-model="subject" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition-colors duration-150 bg-white">
                                        <option value="">Select a subject</option>
                                        <option value="general" {{ old('subject') === 'general' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="booking" {{ old('subject') === 'booking' ? 'selected' : '' }}>Booking Inquiry</option>
                                        <option value="package" {{ old('subject') === 'package' ? 'selected' : '' }}>Package Information</option>
                                        <option value="complaint" {{ old('subject') === 'complaint' ? 'selected' : '' }}>Complaint / Feedback</option>
                                        <option value="other" {{ old('subject') === 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('subject') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div x-show="subject === 'package' || subject === 'booking'" x-cloak x-transition>
                                <label for="package_id" class="block text-sm font-medium text-gray-700 mb-1.5">Related Package</label>
                                <select id="package_id" name="package_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition-colors duration-150 bg-white">
                                    <option value="">Select a package (optional)</option>
                                    @foreach(\App\Models\Package::where('is_active', true)->orderBy('name')->get() as $pkg)
                                        <option value="{{ $pkg->id }}" {{ old('package_id') == $pkg->id ? 'selected' : '' }}>{{ $pkg->name }} - RM {{ number_format((float) ($pkg->discount_price ?? $pkg->price), 0) }}</option>
                                    @endforeach
                                </select>
                                @error('package_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1.5">Message <span class="text-red-500">*</span></label>
                                <textarea id="message" name="message" rows="5" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition-colors duration-150 resize-y" placeholder="How can we help you?">{{ old('message') }}</textarea>
                                @error('message') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors duration-200 shadow-md shadow-emerald-500/20">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-5">Contact Information</h3>
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Address</p>
                                <p class="text-gray-600 text-sm mt-1">No. 2, Menara 1, Jalan P5/6,<br>Presint 5, 62200 Putrajaya</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Phone</p>
                                <p class="text-gray-600 text-sm mt-1">+603-8000 8000</p>
                                <p class="text-gray-600 text-sm">+6012-345 6789 (WhatsApp)</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Email</p>
                                <p class="text-gray-600 text-sm mt-1">info@usrahtravel.com</p>
                                <p class="text-gray-600 text-sm">booking@usrahtravel.com</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Operating Hours</p>
                                <p class="text-gray-600 text-sm mt-1">Monday - Friday: 9:00 AM - 6:00 PM</p>
                                <p class="text-gray-600 text-sm">Saturday: 9:00 AM - 1:00 PM</p>
                                <p class="text-gray-600 text-sm">Sunday & Public Holidays: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <p class="text-sm font-medium">Map Location</p>
                            <p class="text-xs">Putrajaya, Malaysia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
            <p class="text-gray-600">Find answers to common questions about our Umrah and travel services.</p>
        </div>

        <div class="space-y-3" x-data="{ open: null }">
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between px-6 py-4 text-left bg-white hover:bg-gray-50 transition-colors duration-150">
                    <span class="font-semibold text-gray-900 text-sm pr-4">What documents do I need to prepare for Umrah?</span>
                    <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open === 1" x-cloak x-transition>
                    <div class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                        You will need a valid Malaysian passport (at least 6 months before expiry), passport-sized photographs, vaccination certificate, and a marriage certificate (for couples). We will guide you through the complete documentation process and handle the visa application on your behalf.
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between px-6 py-4 text-left bg-white hover:bg-gray-50 transition-colors duration-150">
                    <span class="font-semibold text-gray-900 text-sm pr-4">How far in advance should I book my Umrah package?</span>
                    <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open === 2" x-cloak x-transition>
                    <div class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                        We recommend booking at least 3 to 6 months in advance, especially during peak seasons (Ramadan, school holidays, and public holidays). Early booking ensures better flight availability, hotel options closer to Masjidil Haram, and often better rates.
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between px-6 py-4 text-left bg-white hover:bg-gray-50 transition-colors duration-150">
                    <span class="font-semibold text-gray-900 text-sm pr-4">Do you offer instalment payment plans?</span>
                    <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open === 3" x-cloak x-transition>
                    <div class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                        Yes, we offer flexible instalment plans for all our packages. Typically, we require an initial deposit upon booking, followed by monthly instalments until the full payment is completed before departure. Contact us for specific payment schedules tailored to your chosen package.
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="open = open === 4 ? null : 4" class="w-full flex items-center justify-between px-6 py-4 text-left bg-white hover:bg-gray-50 transition-colors duration-150">
                    <span class="font-semibold text-gray-900 text-sm pr-4">What is included in the Umrah package?</span>
                    <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open === 4" x-cloak x-transition>
                    <div class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                        Our Umrah packages typically include return flights, hotel accommodation (near Masjidil Haram and Masjid Nabawi), Saudi visa processing, ground transportation in Saudi Arabia, Umrah guidance by an experienced mutawwif, and meals as specified in the package. Please refer to individual package details for the complete list of inclusions and exclusions.
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="open = open === 5 ? null : 5" class="w-full flex items-center justify-between px-6 py-4 text-left bg-white hover:bg-gray-50 transition-colors duration-150">
                    <span class="font-semibold text-gray-900 text-sm pr-4">Can I customise a package for my family or group?</span>
                    <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 5 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open === 5" x-cloak x-transition>
                    <div class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                        Absolutely! We specialise in creating custom packages for families, corporate groups, and organisations. Whether you need specific hotel preferences, extended stays, or additional destinations, our team will work with you to create the perfect itinerary. Contact us with your requirements and we'll prepare a tailored proposal for you.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

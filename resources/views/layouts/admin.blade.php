<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ cookie('theme') === 'dark' ? 'dark' : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Admin') - {{ config('app.name', 'Usrah Travel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            [x-cloak] { display: none !important; }
            if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 transition-colors duration-200" x-data="{ sidebarOpen: false }">

        <div class="flex h-screen overflow-hidden">

            <aside x-cloak
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed inset-y-0 left-0 z-50 w-64 bg-emerald-900 dark:bg-emerald-950 transform transition-transform duration-200 ease-in-out lg:relative lg:translate-x-0 lg:inset-0">

                <div class="flex items-center justify-between h-16 px-4 bg-emerald-950 dark:bg-black">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xl font-bold text-white">Usrah Travel</span>
                    </a>
                    <button @click="sidebarOpen = false" class="text-emerald-300 hover:text-white lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <nav class="mt-4 flex-1 px-3 pb-4 overflow-y-auto">
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('admin.bookings.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.bookings.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Bookings
                        </a>

                        <a href="{{ route('admin.customers.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.customers.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Customers
                        </a>

                        <a href="{{ route('admin.packages.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.packages.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Packages
                        </a>

                        <a href="{{ route('admin.payments.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.payments.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Payments
                        </a>

                        <a href="{{ route('admin.invoices.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.invoices.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                            </svg>
                            Invoices
                        </a>

                        <a href="{{ route('admin.vendors.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.vendors.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Vendors
                        </a>

                        <a href="{{ route('admin.tours.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.tours.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            Tour Operations
                        </a>

                        <a href="{{ route('admin.documents.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.documents.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Documents
                        </a>

                        <a href="{{ route('admin.contacts.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.contacts.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contacts
                        </a>

                        <a href="{{ route('admin.reports') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.reports') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Reports
                        </a>

                        @role('admin')
                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150
                                  {{ request()->routeIs('admin.users.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            Users
                        </a>
                        @endrole
                    </div>
                </nav>

                <div class="border-t border-emerald-800 dark:border-emerald-900 p-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-emerald-600 flex items-center justify-center text-white font-medium text-sm">
                            {{ Auth::user()->name[0] ?? 'U' }}
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-emerald-300 truncate">{{ Auth::user()->role }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit"
                                    class="text-emerald-400 hover:text-white transition-colors duration-150"
                                    title="Logout">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false"
                 class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 lg:hidden"></div>

            <div class="flex-1 flex flex-col overflow-hidden">

                <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 z-30">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = true" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 lg:hidden mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                            <h1 class="text-lg font-semibold text-gray-800 dark:text-white">@yield('title', 'Dashboard')</h1>
                        </div>

                        <div class="flex items-center space-x-4">
                            <button @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
                                    class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-150"
                                    title="Toggle Dark Mode">
                                <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                                <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </button>

                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                    <div class="w-8 h-8 rounded-full bg-emerald-600 flex items-center justify-center text-white font-medium text-sm">
                                        {{ Auth::user()->name[0] ?? 'U' }}
                                    </div>
                                    <span class="hidden sm:inline text-sm font-medium">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900">
                    <div class="p-4 sm:p-6 lg:p-8">
                        @yield('content')
                    </div>
                </main>

            </div>
        </div>

    </body>
</html>

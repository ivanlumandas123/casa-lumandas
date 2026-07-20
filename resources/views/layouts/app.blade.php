<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Casa Lumandas') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
</head>
<body class="font-sans antialiased" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex bg-gray-50 text-gray-700">

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed z-30 inset-y-0 left-0 w-64 bg-white border-r border-gray-100 transform transition-transform duration-200 lg:translate-x-0 lg:static lg:inset-auto flex flex-col">
            <div class="h-16 flex items-center gap-2 px-6 border-b border-gray-100">
                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-500" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="8" width="40" height="36" rx="6" stroke="currentColor" stroke-width="3"/>
                        <path d="M4 18H44" stroke="currentColor" stroke-width="3"/>
                        <path d="M16 29L21 34L32 23" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-800">Casa <span class="text-amber-500">Lumandas</span></span>
            </div>

            <div class="px-4 pt-4">
                <span class="inline-block px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wider bg-amber-50 text-amber-600 rounded-full">
                    {{ auth()->user()->isAdmin() ? 'Admin Dashboard' : 'User Dashboard' }}
                </span>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-amber-50 text-amber-700 border-l-4 border-amber-400' : 'hover:bg-gray-50 text-gray-600 border-l-4 border-transparent' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.*') ? 'bg-amber-50 text-amber-700 border-l-4 border-amber-400' : 'hover:bg-gray-50 text-gray-600 border-l-4 border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4" /></svg>
                        Users
                    </a>
                @endif

                <a href="{{ route('rooms.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('rooms.*') ? 'bg-amber-50 text-amber-700 border-l-4 border-amber-400' : 'hover:bg-gray-50 text-gray-600 border-l-4 border-transparent' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9.75L12 3l9 6.75V21a1 1 0 01-1 1h-4a1 1 0 01-1-1v-5a1 1 0 00-1-1h-4a1 1 0 00-1 1v5a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z" /></svg>
                    {{ auth()->user()->isAdmin() ? 'Rooms' : 'Browse Rooms' }}
                </a>

                <a href="{{ route('bookings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('bookings.*') ? 'bg-amber-50 text-amber-700 border-l-4 border-amber-400' : 'hover:bg-gray-50 text-gray-600 border-l-4 border-transparent' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    {{ auth()->user()->isAdmin() ? 'Bookings' : 'My Bookings' }}
                </a>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('profile.edit') ? 'bg-amber-50 text-amber-700 border-l-4 border-amber-400' : 'hover:bg-gray-50 text-gray-600 border-l-4 border-transparent' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Profile
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/30 z-20 lg:hidden" x-cloak></div>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    @isset($header)
                        {{ $header }}
                    @endisset
                </div>

                <div class="flex items-center gap-3">
                    @if (auth()->user()->isAdmin())
                        <span class="px-2.5 py-1 text-xs font-medium bg-amber-100 text-amber-700 rounded-full">Admin</span>
                    @endif
                    <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-gray-600 hidden sm:block">{{ auth()->user()->name }}</span>
                </div>
            </header>

            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>
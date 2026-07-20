<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Casa Lumandas') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="antialiased bg-white">

    <div class="relative bg-[#0f1c30] overflow-hidden">

        <!-- navbar -->
        <header class="relative z-20 max-w-7xl mx-auto flex items-center justify-between px-6 sm:px-10 py-6">
            <a href="/" class="flex items-center gap-2">
                <svg class="w-8 h-8 text-amber-400" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="4" y="8" width="40" height="36" rx="6" stroke="currentColor" stroke-width="3"/>
                    <path d="M4 18H44" stroke="currentColor" stroke-width="3"/>
                    <path d="M14 4V12" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    <path d="M34 4V12" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    <path d="M16 29L21 34L32 23" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="text-xl font-semibold text-white">Casa<span class="text-amber-400">Lumandas</span></span>
            </a>

            <div class="flex items-center gap-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-amber-400 text-[#0f1c30] rounded-full font-semibold text-sm hover:bg-amber-300 transition">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-white/80 hover:text-white text-sm font-medium">Log In</a>
                    <a href="{{ route('register') }}" class="flex items-center gap-2 px-5 py-2.5 bg-amber-400 text-[#0f1c30] rounded-full font-semibold text-sm hover:bg-amber-300 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Register
                    </a>
                @endauth
            </div>
        </header>

        <!-- hero -->
        <div class="relative">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1600&q=80"
                     alt="Cozy room"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-[#0f1c30]/80"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#0f1c30] via-[#0f1c30]/70 to-transparent"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-10 pt-8 pb-40">
                <div class="max-w-xl py-16">
                    <p class="text-amber-400 text-sm font-semibold tracking-[0.2em] uppercase mb-4">Simple. Reliable. Yours.</p>
                    <h1 class="font-display text-5xl sm:text-6xl leading-tight text-white">
                        Book Your <span class="text-amber-400">Stay Now</span>
                    </h1>
                    <div class="w-16 h-1 bg-amber-400 rounded-full my-6"></div>
                    <p class="text-white/70 max-w-md leading-relaxed">
                        Reserve your room in seconds. Track your bookings, manage your schedule, all in one place.
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 mt-8 px-7 py-3.5 bg-amber-400 text-[#0f1c30] rounded-full font-semibold text-sm hover:bg-amber-300 transition">
                        Book Your Stay Now
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- wave divider -->
        <svg class="absolute bottom-0 left-0 w-full text-white" viewBox="0 0 1440 100" fill="currentColor" preserveAspectRatio="none">
            <path d="M0,60 C360,120 1080,0 1440,60 L1440,100 L0,100 Z"></path>
        </svg>
    </div>

    <!-- features -->
    <div class="max-w-6xl mx-auto px-6 sm:px-10 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 sm:gap-6 divide-y sm:divide-y-0 sm:divide-x divide-gray-200">
            <div class="flex items-start gap-4 sm:pr-6 pt-8 sm:pt-0">
                <div class="w-14 h-14 shrink-0 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <div>
                    <h3 class="font-display text-lg text-[#0f1c30] font-semibold">Easy Scheduling</h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">Pick a date and room that works for you, in just a few clicks.</p>
                </div>
            </div>

            <div class="flex items-start gap-4 sm:px-6 pt-8 sm:pt-0">
                <div class="w-14 h-14 shrink-0 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" /></svg>
                </div>
                <div>
                    <h3 class="font-display text-lg text-[#0f1c30] font-semibold">Instant Confirmation</h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">Know exactly where your booking stands — pending, confirmed, or cancelled.</p>
                </div>
            </div>

            <div class="flex items-start gap-4 sm:pl-6 pt-8 sm:pt-0">
                <div class="w-14 h-14 shrink-0 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4" /></svg>
                </div>
                <div>
                    <h3 class="font-display text-lg text-[#0f1c30] font-semibold">Manage Everything</h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">View, edit, or cancel your bookings anytime from your dashboard.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer class="bg-[#0f1c30] py-6">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-white/60 text-sm">
                <svg class="w-5 h-5 text-amber-400" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="4" y="8" width="40" height="36" rx="6" stroke="currentColor" stroke-width="3"/>
                    <path d="M4 18H44" stroke="currentColor" stroke-width="3"/>
                    <path d="M16 29L21 34L32 23" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                © {{ date('Y') }} BookingSystem. All rights reserved.
            </div>
            <div class="flex items-center gap-3">
                <a href="#" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.5 9.87v-6.98h-2.5V12h2.5V9.8c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.23.2 2.23.2v2.45h-1.25c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.98A10 10 0 0022 12z"/></svg>
                </a>
                <a href="#" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.49-1.75.85-2.72 1.05a4.28 4.28 0 00-7.29 3.9 12.14 12.14 0 01-8.82-4.47 4.28 4.28 0 001.32 5.71c-.7-.02-1.36-.21-1.94-.53v.05a4.28 4.28 0 003.43 4.2c-.65.18-1.34.2-2 .08a4.29 4.29 0 004 2.98A8.6 8.6 0 012 18.58a12.1 12.1 0 006.56 1.92c7.88 0 12.2-6.53 12.2-12.2l-.01-.56c.84-.6 1.56-1.36 2.13-2.22z"/></svg>
                </a>
                <a href="#" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.72 3.72 0 01-1.38-.9 3.72 3.72 0 01-.9-1.38c-.16-.42-.36-1.06-.41-2.23-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63c-.79.31-1.46.72-2.13 1.39A5.9 5.9 0 00.62 4.15c-.3.76-.5 1.64-.56 2.91C0 8.34 0 8.74 0 12s.01 3.67.06 4.94c.06 1.27.26 2.15.56 2.91.31.79.72 1.46 1.39 2.13a5.9 5.9 0 002.13 1.39c.76.3 1.64.5 2.91.56C8.33 24 8.74 24 12 24s3.67-.01 4.94-.06c1.27-.06 2.15-.26 2.91-.56a5.9 5.9 0 002.13-1.39 5.9 5.9 0 001.39-2.13c.3-.76.5-1.64.56-2.91.05-1.27.06-1.67.06-4.94s-.01-3.67-.06-4.94c-.06-1.27-.26-2.15-.56-2.91a5.9 5.9 0 00-1.39-2.13A5.9 5.9 0 0019.85.62c-.76-.3-1.64-.5-2.91-.56C15.67.01 15.26 0 12 0z"/><path d="M12 5.84A6.16 6.16 0 1012 18.16 6.16 6.16 0 0012 5.84zm0 10.16a4 4 0 110-8 4 4 0 010 8z"/><circle cx="18.41" cy="5.59" r="1.44"/></svg>
                </a>
            </div>
        </div>
    </footer>

</body>
</html>
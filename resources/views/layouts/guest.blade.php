<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bookings') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex">

        <!-- Left brand panel -->
        <div class="flex w-1/2 relative bg-[#0f1c30] overflow-hidden flex-col justify-between p-12">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1200&q=80" class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-[#0f1c30]/80"></div>
            </div>

            <div class="absolute -left-10 -top-10 w-56 h-56 border border-amber-400/20 rounded-full pointer-events-none"></div>
            <div class="absolute right-10 bottom-10 w-72 h-72 border border-amber-400/10 rounded-full pointer-events-none"></div>

            <a href="/" class="relative z-10 flex items-center gap-2">
                <svg class="w-8 h-8 text-amber-400" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="4" y="8" width="40" height="36" rx="6" stroke="currentColor" stroke-width="3"/>
                    <path d="M4 18H44" stroke="currentColor" stroke-width="3"/>
                    <path d="M14 4V12" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    <path d="M34 4V12" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    <path d="M16 29L21 34L32 23" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="text-xl font-semibold text-white">Bookings</span>
            </a>

            <div class="relative z-10">
                <p class="text-amber-400 text-sm font-semibold tracking-[0.2em] uppercase mb-4">Simple. Reliable. Yours.</p>
                <h1 class="font-display text-5xl leading-tight text-white">
                    Manage & Book <span class="text-amber-400">Your Services</span>
                </h1>
                <div class="w-16 h-1 bg-amber-400 rounded-full my-6"></div>
                <p class="text-white/70 max-w-md leading-relaxed">
                    Reserve your appointment in seconds. Track your bookings, manage your schedule, all in one place.
                </p>
            </div>

            <div class="relative z-10 grid grid-cols-3 gap-6">
                <div>
                    <div class="w-12 h-12 rounded-full bg-white/5 border border-amber-400/30 flex items-center justify-center text-amber-400 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <p class="text-white font-medium text-sm">Easy Scheduling</p>
                    <p class="text-white/50 text-xs mt-1 leading-relaxed">Pick a date and time that works for you.</p>
                </div>
                <div>
                    <div class="w-12 h-12 rounded-full bg-white/5 border border-amber-400/30 flex items-center justify-center text-amber-400 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <p class="text-white font-medium text-sm">Instant Confirmation</p>
                    <p class="text-white/50 text-xs mt-1 leading-relaxed">Get confirmed instantly and stay updated.</p>
                </div>
                <div>
                    <div class="w-12 h-12 rounded-full bg-white/5 border border-amber-400/30 flex items-center justify-center text-amber-400 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p class="text-white font-medium text-sm">Manage Everything</p>
                    <p class="text-white/50 text-xs mt-1 leading-relaxed">View, edit, or cancel your bookings anytime.</p>
                </div>
            </div>
        </div>

        <!-- Right form panel -->
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-slate-50 px-6 py-12">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
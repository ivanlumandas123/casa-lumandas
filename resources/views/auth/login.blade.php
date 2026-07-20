<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="flex flex-col items-center text-center mb-6">
            <div class="w-16 h-16 rounded-full bg-[#0f1c30] flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-amber-400" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="4" y="8" width="40" height="36" rx="6" stroke="currentColor" stroke-width="3"/>
                    <path d="M4 18H44" stroke="currentColor" stroke-width="3"/>
                    <path d="M16 29L21 34L32 23" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2 class="font-display text-2xl font-semibold text-[#0f1c30]">Welcome Back</h2>
            <p class="text-sm text-gray-500 mt-1">Sign in to your account to continue</p>
            <div class="w-10 h-1 bg-amber-400 rounded-full mt-4"></div>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        placeholder="Enter your email"
                        class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:border-amber-400 focus:ring-amber-400 text-sm">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <div class="relative" x-data="{ show: false }">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z" /></svg>
                    </span>
                    <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                        placeholder="Enter your password"
                        class="w-full pl-11 pr-11 py-3 border border-gray-300 rounded-lg focus:border-amber-400 focus:ring-amber-400 text-sm">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between text-sm">
                <label for="remember_me" class="inline-flex items-center gap-2">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-amber-500 focus:ring-amber-400">
                    <span class="text-gray-600">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-amber-600 hover:text-amber-700 font-medium">
                        Forgot your password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#0f1c30] text-white py-3.5 rounded-lg font-semibold text-sm hover:bg-[#16274a] transition">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l4-4m0 0l-4-4m4 4H3m8 6a9 9 0 100-18" /></svg>
                LOG IN
            </button>

            <p class="text-center text-sm text-gray-500">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-amber-600 hover:text-amber-700 font-medium">Create one</a>
            </p>
        </form>
    </div>
</x-guest-layout>
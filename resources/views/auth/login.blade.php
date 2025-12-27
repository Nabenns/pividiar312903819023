<x-guest-layout>
    <div class="glass-card p-8 rounded-3xl border border-white/10 shadow-2xl w-full">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
            <p class="text-gray-400 text-sm">Enter your details to access your account.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="relative">
                <x-input-label for="email" :value="__('Email')" class="text-gray-300 sr-only" />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="email" class="block mt-1 w-full pl-10 py-3 bg-white/5 border-white/10 text-white placeholder-gray-500 focus:border-brand-orange focus:ring-brand-orange rounded-xl shadow-sm transition duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email Address" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 relative">
                <x-input-label for="password" :value="__('Password')" class="text-gray-300 sr-only" />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password" class="block mt-1 w-full pl-10 py-3 bg-white/5 border-white/10 text-white placeholder-gray-500 focus:border-brand-orange focus:ring-brand-orange rounded-xl shadow-sm transition duration-200"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="Password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded bg-white/10 border-white/20 text-brand-orange shadow-sm focus:ring-brand-orange" name="remember">
                    <span class="ms-2 text-sm text-gray-400 select-none">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-brand-orange hover:text-white transition" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="mt-6">
                <button type="submit" class="relative overflow-hidden w-full py-3.5 bg-brand-orange border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-orange-600 active:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-[0_0_15px_rgba(255,159,28,0.3)] hover:shadow-[0_0_25px_rgba(255,159,28,0.5)] transform hover:-translate-y-0.5 group">
                    <span class="relative z-10">Log in</span>
                    <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent z-0"></div>
                </button>
            </div>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-brand-orange hover:text-white font-medium transition">Sign up</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>

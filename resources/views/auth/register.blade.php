<x-guest-layout>
    <div class="glass-card p-8 rounded-3xl border border-white/10 shadow-2xl w-full">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-2">Create Account</h2>
            <p class="text-gray-400 text-sm">Join Pividiar Capital today.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" x-data="{ 
            password: '', 
            showPassword: false,
            get strength() {
                let score = 0;
                if (this.password.length > 4) score++;
                if (this.password.length > 7) score++;
                if (/[A-Z]/.test(this.password)) score++;
                if (/[0-9]/.test(this.password)) score++;
                return score;
            }
        }">
            @csrf

            <!-- Name -->
            <div class="relative group">
                <input type="text" id="name" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder=" "
                    class="block px-4 pb-3 pt-6 w-full text-sm text-white bg-white/5 border-white/10 rounded-xl appearance-none focus:outline-none focus:ring-0 focus:border-brand-orange peer transition-colors" />
                <label for="name" 
                    class="absolute text-sm text-gray-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-focus:text-brand-orange peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 cursor-text">
                    Full Name
                </label>
                <div class="absolute right-3 top-4 text-gray-500 peer-focus:text-brand-orange transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-5 relative group">
                <input type="email" id="email" name="email" :value="old('email')" required autocomplete="username" placeholder=" "
                    class="block px-4 pb-3 pt-6 w-full text-sm text-white bg-white/5 border-white/10 rounded-xl appearance-none focus:outline-none focus:ring-0 focus:border-brand-orange peer transition-colors" />
                <label for="email" 
                    class="absolute text-sm text-gray-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-focus:text-brand-orange peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 cursor-text">
                    Email Address
                </label>
                <div class="absolute right-3 top-4 text-gray-500 peer-focus:text-brand-orange transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-5 relative group">
                <input :type="showPassword ? 'text' : 'password'" id="password" name="password" x-model="password" required autocomplete="new-password" placeholder=" "
                    class="block px-4 pb-3 pt-6 w-full text-sm text-white bg-white/5 border-white/10 rounded-xl appearance-none focus:outline-none focus:ring-0 focus:border-brand-orange peer transition-colors pr-10" />
                <label for="password" 
                    class="absolute text-sm text-gray-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-focus:text-brand-orange peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 cursor-text">
                    Password
                </label>
                
                <!-- Toggle Show/Hide -->
                <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-4 text-gray-500 hover:text-white focus:outline-none transition-colors">
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Password Strength Meter -->
            <div class="mt-2 flex gap-1 h-1" x-show="password.length > 0" x-transition>
                <div class="flex-1 rounded-full bg-gray-700 transition-colors duration-300" :class="strength >= 1 ? 'bg-red-500' : ''"></div>
                <div class="flex-1 rounded-full bg-gray-700 transition-colors duration-300" :class="strength >= 2 ? 'bg-yellow-500' : ''"></div>
                <div class="flex-1 rounded-full bg-gray-700 transition-colors duration-300" :class="strength >= 3 ? 'bg-green-500' : ''"></div>
                <div class="flex-1 rounded-full bg-gray-700 transition-colors duration-300" :class="strength >= 4 ? 'bg-brand-orange' : ''"></div>
            </div>
            <p class="text-xs text-gray-500 mt-1 text-right" x-show="password.length > 0">
                <span x-show="strength <= 1">Weak</span>
                <span x-show="strength == 2">Fair</span>
                <span x-show="strength == 3">Good</span>
                <span x-show="strength >= 4">Strong</span>
            </p>

            <div class="mt-8">
                <button type="submit" class="relative overflow-hidden w-full py-3.5 bg-brand-orange border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-orange-600 active:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-[0_0_15px_rgba(255,159,28,0.3)] hover:shadow-[0_0_25px_rgba(255,159,28,0.5)] transform hover:-translate-y-0.5 group">
                    <span class="relative z-10">Register</span>
                    <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent z-0"></div>
                </button>
            </div>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-brand-orange hover:text-white font-medium transition">Log in</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>

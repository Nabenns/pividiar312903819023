<nav x-data="{ open: false }" class="bg-[#020617]/80 backdrop-blur-xl border-b border-white/5 sticky top-0 z-50 transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group flex items-center">
                        <span class="text-2xl font-bold text-white tracking-tight group-hover:text-gray-100 transition-colors">
                            pividiar<span class="text-brand-orange">.</span>
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-sm font-medium transition-all duration-300 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 hover:text-white' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('academy.index')" :active="request()->routeIs('academy.*')" class="text-sm font-medium transition-all duration-300 {{ request()->routeIs('academy.*') ? 'text-white' : 'text-gray-400 hover:text-white' }}">
                        {{ __('Academy') }}
                    </x-nav-link>

                    <x-nav-link :href="route('affiliate.index')" :active="request()->routeIs('affiliate.*')" class="text-sm font-medium transition-all duration-300 {{ request()->routeIs('affiliate.*') ? 'text-white' : 'text-gray-400 hover:text-white' }}">
                        {{ __('Affiliate') }}
                    </x-nav-link>

                    <x-nav-link :href="route('journal.index')" :active="request()->routeIs('journal.*')" class="text-sm font-medium transition-all duration-300 {{ request()->routeIs('journal.*') ? 'text-white' : 'text-gray-400 hover:text-white' }}">
                        {{ __('Journal') }}
                    </x-nav-link>

                    <!-- Tools Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-400 hover:text-white focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs('tools.*') ? 'text-white' : '' }}">
                                    <div>Tools</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="bg-[#0b172e] border border-white/10 rounded-xl shadow-2xl overflow-hidden ring-1 ring-black ring-opacity-5">
                                    <x-dropdown-link :href="route('tools.calculator')" class="text-gray-300 hover:bg-white/5 hover:text-white transition-colors px-4 py-2">
                                        {{ __('Position Calculator') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('tools.calendar')" class="text-gray-300 hover:bg-white/5 hover:text-white transition-colors px-4 py-2">
                                        {{ __('Economic Calendar') }}
                                    </x-dropdown-link>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-white/5 text-sm leading-4 font-medium rounded-full text-gray-300 bg-white/5 hover:bg-white/10 hover:text-white focus:outline-none transition ease-in-out duration-300">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center text-xs font-bold text-white">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </div>

                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4 text-gray-500 group-hover:text-gray-300 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-[#0b172e] border border-white/10 rounded-xl shadow-2xl overflow-hidden ring-1 ring-black ring-opacity-5">
                            <div class="px-4 py-3 border-b border-white/5">
                                <p class="text-sm text-white font-medium">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:bg-white/5 hover:text-white transition-colors px-4 py-2">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" class="text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors px-4 py-2"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out relative z-50 cursor-pointer">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="sm:hidden bg-[#020617] border-b border-white/10 absolute w-full z-40"
         style="display: none;">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-white hover:bg-white/5 border-l-4 border-transparent hover:border-brand-orange transition-all">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('academy.index')" :active="request()->routeIs('academy.*')" class="text-gray-300 hover:text-white hover:bg-white/5 border-l-4 border-transparent hover:border-brand-orange transition-all">
                {{ __('Academy') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('affiliate.index')" :active="request()->routeIs('affiliate.*')" class="text-gray-300 hover:text-white hover:bg-white/5 border-l-4 border-transparent hover:border-brand-orange transition-all">
                {{ __('Affiliate') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('journal.index')" :active="request()->routeIs('journal.*')" class="text-gray-300 hover:text-white hover:bg-white/5 border-l-4 border-transparent hover:border-brand-orange transition-all">
                {{ __('Journal') }}
            </x-responsive-nav-link>

            <!-- Tools Mobile Dropdown -->
            <div x-data="{ toolsOpen: false }">
                <button @click="toolsOpen = !toolsOpen" class="w-full flex items-center justify-between ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-300 hover:text-white hover:bg-white/5 hover:border-brand-orange transition-all focus:outline-none">
                    <span>{{ __('Tools') }}</span>
                    <svg class="h-4 w-4 transform transition-transform duration-200" :class="{'rotate-180': toolsOpen}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="toolsOpen" class="space-y-1 bg-black/20">
                    <x-responsive-nav-link :href="route('tools.calculator')" :active="request()->routeIs('tools.calculator')" class="ps-8 text-sm text-gray-400 hover:text-white">
                        {{ __('Position Calculator') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('tools.calendar')" :active="request()->routeIs('tools.calendar')" class="ps-8 text-sm text-gray-400 hover:text-white">
                        {{ __('Economic Calendar') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10 bg-white/5">
            <div class="px-4 flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center text-sm font-bold text-white">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300 hover:text-white hover:bg-white/5">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" class="text-red-400 hover:text-red-300 hover:bg-red-500/10"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

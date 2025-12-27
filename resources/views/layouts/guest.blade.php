<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800" rel="stylesheet" />
        <style>
            body { font-family: 'Outfit', sans-serif; }
            :root {
                --brand-dark: #020B1C;
                --brand-blue: #0A1935;
                --brand-orange: #FF9F1C;
            }
            .bg-brand-dark { background-color: var(--brand-dark); }
            .text-brand-orange { color: var(--brand-orange); }
            
            .glass-card {
                background: linear-gradient(145deg, rgba(16, 30, 60, 0.6), rgba(5, 15, 35, 0.8));
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-brand-dark overflow-hidden selection:bg-orange-500 selection:text-white">
        <div class="min-h-screen flex">
            <!-- Left Side: Visuals (Hidden on Mobile) -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-brand-dark overflow-hidden flex-col justify-between p-12 z-0">
                <!-- Background Elements -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                     <div class="absolute top-[-10%] left-[-10%] w-[600px] h-[600px] bg-blue-900/20 rounded-full mix-blend-screen filter blur-[120px] animate-pulse"></div>
                     <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-orange-600/10 rounded-full mix-blend-screen filter blur-[120px]"></div>
                     <div class="absolute top-[40%] left-[30%] w-[300px] h-[300px] bg-brand-orange/5 rounded-full mix-blend-screen filter blur-[80px] animate-pulse" style="animation-duration: 4s;"></div>
                     
                     <!-- Abstract Texture -->
                     <svg class="absolute inset-0 w-full h-full opacity-[0.03]" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M0 40L40 0H20L0 20M40 40V20L20 40" stroke="white" stroke-width="1" fill="none"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid-pattern)"/>
                     </svg>
                </div>

                <!-- Logo -->
                <div class="relative z-10">
                    <a href="/" class="text-5xl font-extrabold tracking-tighter flex items-center gap-1 group">
                        <span class="text-white">pividiar</span>
                        <span class="text-brand-orange animate-pulse">.</span>
                    </a>
                </div>

                <!-- Quote / Content -->
                <div class="relative z-10 max-w-lg">
                    <h2 class="text-4xl font-bold text-white leading-tight mb-6">
                        Master the Art of <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-orange to-orange-400">Smart Trading.</span>
                    </h2>
                    <p class="text-gray-400 text-lg leading-relaxed mb-8">
                        Join thousands of traders who are redefining their financial future with Pividiar Capital's premium education and tools.
                    </p>
                    
                    <div class="flex items-center gap-4">
                        <div class="flex -space-x-4">
                            <img class="w-10 h-10 rounded-full border-2 border-brand-dark" src="https://ui-avatars.com/api/?name=Alex+D&background=random" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-brand-dark" src="https://ui-avatars.com/api/?name=Sarah+M&background=random" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-brand-dark" src="https://ui-avatars.com/api/?name=John+K&background=random" alt="User">
                            <div class="w-10 h-10 rounded-full border-2 border-brand-dark bg-gray-800 flex items-center justify-center text-xs text-white font-bold">+2k</div>
                        </div>
                        <div class="text-sm text-gray-400">
                            <span class="text-white font-bold">4.9/5</span> rating from our community
                        </div>
                    </div>
                </div>

                <!-- Footer Copyright -->
                <div class="relative z-10 text-gray-500 text-sm">
                    &copy; {{ date('Y') }} Pividiar Capital. All rights reserved.
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 bg-[#050f25] relative z-10 border-l border-white/5">
                <!-- Back to Home -->
                <a href="/" class="absolute top-8 left-8 text-gray-400 hover:text-white transition flex items-center gap-2 text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Home
                </a>

                <!-- Mobile Logo (Visible only on mobile) -->
                <div class="lg:hidden mb-8">
                    <a href="/" class="text-3xl font-extrabold tracking-tighter flex items-center gap-1">
                        <span class="text-white">pividiar</span>
                        <span class="text-brand-orange">.</span>
                    </a>
                </div>

                <div class="w-full sm:max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>

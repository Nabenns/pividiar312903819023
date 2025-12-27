<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Pividiar Capital') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        
        :root {
            --brand-dark: #020B1C;
            --brand-blue: #0A1935;
            --brand-orange: #FF9F1C;
            --brand-gold: #FFD700;
        }

        .bg-brand-dark { background-color: var(--brand-dark); }
        .text-brand-orange { color: var(--brand-orange); }
        .bg-brand-orange { background-color: var(--brand-orange); }
        .bg-brand-blue { background-color: var(--brand-blue); }
        .text-brand-dark { color: var(--brand-dark); }

        /* Glassmorphism */
        .glass {
            background: rgba(10, 25, 53, 0.7);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .glass-card {
            background: linear-gradient(145deg, rgba(16, 30, 60, 0.6), rgba(5, 15, 35, 0.8));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            transform-style: preserve-3d; /* For 3D Tilt */
            transition: transform 0.1s ease-out; /* Smooth tilt return */
        }

        .gradient-text {
            background: linear-gradient(to right, #FF9F1C, #FFD700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float 6s ease-in-out 3s infinite; }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee { animation: marquee 40s linear infinite; }
        .animate-marquee:hover { animation-play-state: paused; }

        /* Scroll Reveal */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #020B1C; }
        ::-webkit-scrollbar-thumb { background: #1f2937; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #FF9F1C; }
    </style>
</head>
<body class="bg-brand-dark text-white antialiased selection:bg-orange-500 selection:text-white overflow-x-hidden">

    <!-- Fixed Header Container -->
    <header class="fixed w-full z-50 top-0 left-0">
        <!-- Live Ticker (Top Bar) -->
        <div class="bg-brand-blue/90 backdrop-blur-sm border-b border-white/5 h-10 flex items-center overflow-hidden relative">
            <div class="flex whitespace-nowrap animate-marquee" id="crypto-ticker">
                <span class="text-gray-400 mx-4 text-xs">Loading market data...</span>
            </div>
            <!-- Fade Edges -->
            <div class="absolute inset-y-0 left-0 w-16 bg-gradient-to-r from-brand-blue to-transparent z-10"></div>
            <div class="absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-brand-blue to-transparent z-10"></div>
        </div>

        <!-- Navbar -->
        <nav class="glass transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center group cursor-pointer">
                        <a href="{{ url('/') }}" class="text-3xl font-extrabold tracking-tighter flex items-center gap-1">
                            <span class="text-white group-hover:text-gray-200 transition">pividiar</span>
                            <span class="text-brand-orange animate-pulse">.</span>
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex space-x-8 items-center">
                        <a href="#curriculum" class="text-sm font-medium text-gray-300 hover:text-brand-orange transition relative group">
                            Curriculum
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-orange transition-all group-hover:w-full"></span>
                        </a>
                        <a href="#results" class="text-sm font-medium text-gray-300 hover:text-brand-orange transition relative group">
                            Results
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-orange transition-all group-hover:w-full"></span>
                        </a>
                        <a href="{{ route('pricing') }}" class="text-sm font-medium text-gray-300 hover:text-brand-orange transition relative group">
                            Pricing
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-orange transition-all group-hover:w-full"></span>
                        </a>
                        
                        <div class="h-6 w-px bg-white/10 mx-4"></div>

                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-brand-orange hover:bg-orange-600 text-white px-6 py-2.5 rounded-full font-bold text-sm transition shadow-[0_0_15px_rgba(255,159,28,0.4)] hover:shadow-[0_0_25px_rgba(255,159,28,0.6)] transform hover:-translate-y-0.5">
                                Member Area
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition">Log in</a>
                            <a href="{{ route('register') }}" class="bg-white text-brand-dark hover:bg-gray-100 px-6 py-2.5 rounded-full font-bold text-sm transition shadow-lg transform hover:-translate-y-0.5">
                                Join Class
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button class="text-gray-300 hover:text-white focus:outline-none p-2">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <div class="relative pt-40 pb-20 sm:pt-48 sm:pb-32 overflow-hidden min-h-screen flex items-center">
        <!-- Floating Crypto Icons (Background with Parallax) -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none parallax-container">
            <!-- Bitcoin -->
            <div class="absolute top-1/4 left-10 opacity-10 animate-float parallax-layer" data-speed="0.2">
                <svg class="w-24 h-24 text-brand-orange" fill="currentColor" viewBox="0 0 24 24"><path d="M23.638 14.904c-1.602 6.43-8.113 10.34-14.542 8.736C2.67 22.05-1.244 15.525.362 9.105 1.962 2.67 8.475-1.24 14.9.358c6.43 1.605 10.342 8.115 8.738 14.548v-.002zm-6.35-2.155c.883-2.333-4.913-3.11-6.35-3.47v-1.18h-1.15v1.18c-1.18.295-2.36.59-3.54.885v-1.18h-1.15v1.18c-1.18.295-2.36.59-3.54.885v1.18h1.15c.59 0 1.18.295 1.77.59.59.295.885.59 1.18 1.18v5.9c-.295.295-.59.59-1.18.885-.59.295-1.18.59-1.77.59v1.18h3.54v1.18h1.15v-1.18c1.18-.295 2.36-.59 3.54-.885v1.18h1.15v-1.18c2.95-.59 5.31-2.36 4.72-5.31-.295-1.475-1.475-2.36-2.95-2.95 1.18-.59 2.065-1.475 2.36-2.95z"/></svg>
            </div>
            <!-- Ethereum -->
            <div class="absolute bottom-1/4 right-10 opacity-10 animate-float-delayed parallax-layer" data-speed="-0.3">
                <svg class="w-20 h-20 text-blue-500" fill="currentColor" viewBox="0 0 32 32"><path d="M15.925 0l-0.095 0.325v20.89l0.095 0.095 9.775-5.78-9.775-15.53zM16.075 0l-9.775 15.53 9.775 5.78v-21.31zM15.925 22.845l-0.11 0.135v8.695l0.11 0.325 9.8-13.84-9.8 4.685zM16.075 22.845l-9.8-4.685 9.8 13.84v-9.155zM16.075 14.47l8.685-5.135-8.685-3.945v9.080zM15.925 14.47v-9.080l-8.685 3.945 8.685 5.135z"/></svg>
            </div>
        </div>

        <!-- Background Glows -->
        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-0 pointer-events-none">
            <div class="absolute top-20 left-1/4 w-[500px] h-[500px] bg-blue-900/40 rounded-full mix-blend-screen filter blur-[120px] animate-pulse"></div>
            <div class="absolute top-40 right-1/4 w-[400px] h-[400px] bg-orange-600/30 rounded-full mix-blend-screen filter blur-[120px]"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal active">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-8 backdrop-blur-md hover:bg-white/10 transition cursor-default">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-orange opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-brand-orange"></span>
                </span>
                <span class="text-sm text-gray-300 tracking-wide uppercase font-bold">#1 Crypto Education Platform</span>
            </div>
            
            <h1 class="text-6xl sm:text-8xl font-extrabold tracking-tight mb-8 leading-tight">
                Learn to Trade <br>
                <span class="gradient-text">Like a Pro</span>
            </h1>
            
            <p class="mt-6 text-xl text-gray-400 max-w-2xl mx-auto mb-12 leading-relaxed">
                Join Pividiar Capital's exclusive mentorship program. Master technical analysis, psychology, and risk management with our expert-led courses.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('pricing') }}" class="group bg-brand-orange hover:bg-orange-600 text-white px-10 py-5 rounded-full font-bold text-xl transition transform hover:scale-105 shadow-[0_0_20px_rgba(255,159,28,0.3)] flex items-center justify-center gap-3">
                    Start Learning
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                <a href="#curriculum" class="glass text-white px-10 py-5 rounded-full font-bold text-xl transition hover:bg-white/10 border border-white/10 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    View Curriculum
                </a>
            </div>

            <!-- Hero Image / Dashboard Preview -->
            <div class="mt-24 relative mx-auto max-w-5xl group perspective-1000">
                <div class="absolute -inset-1 bg-gradient-to-r from-brand-orange to-blue-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                <div class="relative glass-card rounded-2xl border border-white/10 p-2 overflow-hidden transform transition duration-500 hover:scale-[1.01] tilt-card">
                    <img src="https://placehold.co/1200x600/020B1C/FFF?text=Pividiar+Classroom+&+Signals+Preview" alt="Classroom Preview" class="rounded-xl w-full opacity-90">
                    <!-- Overlay Grid -->
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImEiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTTAgNDBoNDBWMEgwIiBmaWxsPSJub25lIi8+PHBhdGggZD0iTTAgNDBoMXYtMWgtMXptMjAgMGgxdi0xaC0xeiIgZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjAzKSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNhKSIvPjwvc3ZnPg==')] opacity-30"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section (Animated) -->
    <div id="results" class="py-20 border-y border-white/5 bg-black/20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center reveal">
                <div class="p-6 rounded-2xl hover:bg-white/5 transition duration-300">
                    <div class="text-4xl font-bold text-white mb-2 counter" data-target="5000">0</div>
                    <div class="text-brand-orange text-xs uppercase tracking-widest font-bold">Students Enrolled</div>
                </div>
                <div class="p-6 rounded-2xl hover:bg-white/5 transition duration-300">
                    <div class="text-4xl font-bold text-white mb-2 counter" data-target="500">0</div>
                    <div class="text-brand-orange text-xs uppercase tracking-widest font-bold">Video Modules</div>
                </div>
                <div class="p-6 rounded-2xl hover:bg-white/5 transition duration-300">
                    <div class="text-4xl font-bold text-white mb-2"><span class="counter" data-target="92">0</span>%</div>
                    <div class="text-brand-orange text-xs uppercase tracking-widest font-bold">Success Rate</div>
                </div>
                <div class="p-6 rounded-2xl hover:bg-white/5 transition duration-300">
                    <div class="text-4xl font-bold text-white mb-2">24/7</div>
                    <div class="text-brand-orange text-xs uppercase tracking-widest font-bold">Mentor Support</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Curriculum Syllabus Section (New Feature) -->
    <div id="curriculum" class="py-32 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20 reveal">
                <h2 class="text-brand-orange font-bold tracking-wider uppercase text-sm mb-4">Course Syllabus</h2>
                <h3 class="text-4xl md:text-5xl font-bold text-white">What You Will Learn</h3>
                <p class="mt-4 text-gray-400 max-w-2xl mx-auto">Our structured curriculum takes you from beginner to pro. Each module is designed to build upon the last.</p>
            </div>

            <div class="max-w-4xl mx-auto space-y-6 reveal">
                <!-- Module 1 -->
                <div class="glass-card rounded-2xl overflow-hidden group tilt-card">
                    <button class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-brand-orange/20 rounded-xl flex items-center justify-center text-brand-orange font-bold text-xl">01</div>
                            <div>
                                <h4 class="text-xl font-bold text-white group-hover:text-brand-orange transition">Foundation & Basics</h4>
                                <p class="text-sm text-gray-500">4 Lessons • 2 Hours</p>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-brand-orange transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-8 pb-8 text-gray-400 hidden border-t border-white/5 pt-6 bg-black/20">
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Introduction to Blockchain & Crypto</li>
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Setting up Wallets & Exchanges</li>
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Understanding Market Cycles</li>
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Basic Charting Tools (TradingView)</li>
                        </ul>
                    </div>
                </div>

                <!-- Module 2 -->
                <div class="glass-card rounded-2xl overflow-hidden group tilt-card">
                    <button class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400 font-bold text-xl">02</div>
                            <div>
                                <h4 class="text-xl font-bold text-white group-hover:text-brand-orange transition">Technical Analysis Mastery</h4>
                                <p class="text-sm text-gray-500">8 Lessons • 5 Hours</p>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-brand-orange transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-8 pb-8 text-gray-400 hidden border-t border-white/5 pt-6 bg-black/20">
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Support & Resistance Flip Zones</li>
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Candlestick Patterns & Psychology</li>
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Fibonacci Retracements & Extensions</li>
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Indicators (RSI, MACD, EMA)</li>
                        </ul>
                    </div>
                </div>

                <!-- Module 3 -->
                <div class="glass-card rounded-2xl overflow-hidden group tilt-card">
                    <button class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center text-purple-400 font-bold text-xl">03</div>
                            <div>
                                <h4 class="text-xl font-bold text-white group-hover:text-brand-orange transition">Risk Management & Psychology</h4>
                                <p class="text-sm text-gray-500">5 Lessons • 3 Hours</p>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-brand-orange transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-8 pb-8 text-gray-400 hidden border-t border-white/5 pt-6 bg-black/20">
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Calculating Position Size</li>
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Stop Loss Strategies</li>
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Mastering Trader Psychology</li>
                            <li class="flex items-center gap-3"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Creating a Trading Plan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="py-24 bg-brand-blue/30 border-y border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-brand-orange font-bold tracking-wider uppercase text-sm mb-4">Student Stories</h2>
                <h3 class="text-4xl font-bold text-white">Real Results from Real Students</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Review 1 -->
                <div class="glass-card p-8 rounded-2xl reveal tilt-card">
                    <div class="flex items-center mb-4">
                        <div class="text-brand-orange flex text-lg">★★★★★</div>
                    </div>
                    <p class="text-gray-300 mb-6 italic">"I was losing money for years until I joined Pividiar. The risk management module changed everything for me. Now I'm consistently profitable."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-900 rounded-full mr-3 border border-white/10"></div>
                        <div>
                            <div class="text-white font-bold">Alex Thompson</div>
                            <div class="text-gray-500 text-sm">Student</div>
                        </div>
                    </div>
                </div>
                <!-- Review 2 -->
                <div class="glass-card p-8 rounded-2xl reveal tilt-card">
                    <div class="flex items-center mb-4">
                        <div class="text-brand-orange flex text-lg">★★★★★</div>
                    </div>
                    <p class="text-gray-300 mb-6 italic">"The signals are great, but the education is even better. I finally understand WHY the market moves the way it does."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-900 rounded-full mr-3 border border-white/10"></div>
                        <div>
                            <div class="text-white font-bold">Sarah Jenkins</div>
                            <div class="text-gray-500 text-sm">Crypto Enthusiast</div>
                        </div>
                    </div>
                </div>
                <!-- Review 3 -->
                <div class="glass-card p-8 rounded-2xl reveal tilt-card">
                    <div class="flex items-center mb-4">
                        <div class="text-brand-orange flex text-lg">★★★★★</div>
                    </div>
                    <p class="text-gray-300 mb-6 italic">"The mentors are always available to answer questions. It feels like having a personal coach. Highly recommended!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-900 rounded-full mr-3 border border-white/10"></div>
                        <div>
                            <div class="text-white font-bold">Michael Chen</div>
                            <div class="text-gray-500 text-sm">Part-time Trader</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="py-24">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-brand-orange font-bold tracking-wider uppercase text-sm mb-4">FAQ</h2>
                <h3 class="text-4xl font-bold text-white">Frequently Asked Questions</h3>
            </div>
            <div class="space-y-4 reveal">
                <!-- FAQ Item 1 -->
                <div class="glass-card rounded-xl overflow-hidden group">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                        <span class="text-lg font-bold text-white group-hover:text-brand-orange transition">Is this suitable for beginners?</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-orange transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-400 hidden border-t border-white/5 pt-4">
                        Yes! We have a dedicated "Zero to Hero" module specifically designed for complete beginners. We start from the very basics of blockchain and trading.
                    </div>
                </div>
                <!-- FAQ Item 2 -->
                <div class="glass-card rounded-xl overflow-hidden group">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                        <span class="text-lg font-bold text-white group-hover:text-brand-orange transition">How do I access the signals?</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-orange transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-400 hidden border-t border-white/5 pt-4">
                        Once you subscribe, you will get access to our private dashboard and Telegram/Discord channels where signals are posted in real-time.
                    </div>
                </div>
                <!-- FAQ Item 3 -->
                <div class="glass-card rounded-xl overflow-hidden group">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                        <span class="text-lg font-bold text-white group-hover:text-brand-orange transition">Do you offer refunds?</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-orange transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="px-6 pb-6 text-gray-400 hidden border-t border-white/5 pt-4">
                        We offer a 7-day money-back guarantee if you are not satisfied with the course content.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-brand-orange/10 skew-y-3 transform origin-bottom-left"></div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 reveal">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-8">Ready to Start Your Journey?</h2>
            <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">Join thousands of students who are mastering the crypto markets with Pividiar.</p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
                <a href="{{ route('pricing') }}" class="inline-block bg-white text-brand-dark hover:bg-gray-100 px-12 py-5 rounded-full font-bold text-xl transition shadow-[0_0_30px_rgba(255,255,255,0.3)] transform hover:-translate-y-1">
                    Enroll Now
                </a>
                <div class="flex items-center gap-4 text-gray-400 text-sm">
                    <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Instant Access</span>
                    <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Secure Payment</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-white/10 bg-[#010610] pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-1">
                    <span class="text-2xl font-bold text-white">pividiar<span class="text-brand-orange">.</span></span>
                    <p class="text-gray-500 mt-6 leading-relaxed">
                        The premier destination for crypto education and trading intelligence.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Learn</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="#" class="hover:text-brand-orange transition">Courses</a></li>
                        <li><a href="#" class="hover:text-brand-orange transition">Mentorship</a></li>
                        <li><a href="#" class="hover:text-brand-orange transition">Free Resources</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Company</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="#" class="hover:text-brand-orange transition">About Us</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-brand-orange transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-brand-orange transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Legal</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="#" class="hover:text-brand-orange transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-brand-orange transition">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} Pividiar Capital. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <!-- Social Icons -->
                    <a href="#" class="text-gray-500 hover:text-white transition"><span class="sr-only">Twitter</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // CoinGecko Ticker Script
        const apiKey = 'CG-94Wrzs9AwD9tVZzZQcdmVzZR'; // Provided by user
        const tickerContainer = document.getElementById('crypto-ticker');
        
        async function fetchCryptoPrices() {
            try {
                const response = await fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=15&page=1&sparkline=false&price_change_percentage=24h&x_cg_demo_api_key=' + apiKey);
                const data = await response.json();
                
                let tickerHtml = '';
                data.forEach(coin => {
                    const changeColor = coin.price_change_percentage_24h >= 0 ? 'text-green-400' : 'text-red-400';
                    const arrow = coin.price_change_percentage_24h >= 0 ? '▲' : '▼';
                    
                    tickerHtml += `
                        <div class="inline-flex items-center mx-6">
                            <img src="${coin.image}" class="w-4 h-4 mr-2 rounded-full" alt="${coin.name}">
                            <span class="font-bold text-white mr-1 text-sm">${coin.symbol.toUpperCase()}</span>
                            <span class="text-gray-300 mr-2 text-sm">$${coin.current_price.toLocaleString()}</span>
                            <span class="${changeColor} text-xs font-medium">${arrow} ${Math.abs(coin.price_change_percentage_24h).toFixed(2)}%</span>
                        </div>
                    `;
                });
                
                // Duplicate content for smooth infinite scroll
                tickerContainer.innerHTML = tickerHtml + tickerHtml;
                
            } catch (error) {
                console.error('Error fetching crypto data:', error);
                tickerContainer.innerHTML = '<span class="text-red-400 mx-4">Unable to load market data</span>';
            }
        }

        fetchCryptoPrices();
        // Refresh every 60 seconds
        setInterval(fetchCryptoPrices, 60000);

        // Scroll Reveal & Parallax Script
        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('.reveal');
            const counters = document.querySelectorAll('.counter');
            const parallaxLayers = document.querySelectorAll('.parallax-layer');
            let hasCounted = false;

            function checkReveal() {
                const triggerBottom = window.innerHeight / 5 * 4;

                reveals.forEach(reveal => {
                    const revealTop = reveal.getBoundingClientRect().top;

                    if (revealTop < triggerBottom) {
                        reveal.classList.add('active');
                    }
                });

                // Trigger Counter Animation when Stats section is visible
                const statsSection = document.getElementById('results');
                if (statsSection && !hasCounted) {
                    const statsTop = statsSection.getBoundingClientRect().top;
                    if (statsTop < triggerBottom) {
                        startCounters();
                        hasCounted = true;
                    }
                }
            }

            function startCounters() {
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    const increment = target / 50; // Adjust speed here
                    
                    const updateCounter = () => {
                        const c = +counter.innerText.replace(/,/g, ''); // Remove commas for calculation
                        if (c < target) {
                            counter.innerText = Math.ceil(c + increment).toLocaleString();
                            setTimeout(updateCounter, 30);
                        } else {
                            counter.innerText = target.toLocaleString() + (counter.parentElement.innerText.includes('%') ? '' : '+');
                        }
                    };
                    updateCounter();
                });
            }

            // Parallax Effect
            window.addEventListener('scroll', function() {
                const scrollY = window.scrollY;
                parallaxLayers.forEach(layer => {
                    const speed = layer.getAttribute('data-speed');
                    layer.style.transform = `translateY(${scrollY * speed}px)`;
                });
                checkReveal();
            });

            // 3D Tilt Effect
            const cards = document.querySelectorAll('.tilt-card');
            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateX = ((y - centerY) / centerY) * -5; // Max rotation deg
                    const rotateY = ((x - centerX) / centerX) * 5;

                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
                });
            });

            checkReveal(); // Check on load
        });
    </script>

</body>
</html>

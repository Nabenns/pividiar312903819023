<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pricing - {{ config('app.name', 'Pividiar Capital') }}</title>
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

        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }

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
                        <a href="{{ url('/') }}#curriculum" class="text-sm font-medium text-gray-300 hover:text-brand-orange transition relative group">
                            Curriculum
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-orange transition-all group-hover:w-full"></span>
                        </a>
                        <a href="{{ url('/') }}#results" class="text-sm font-medium text-gray-300 hover:text-brand-orange transition relative group">
                            Results
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-orange transition-all group-hover:w-full"></span>
                        </a>
                        <a href="{{ route('pricing') }}" class="text-sm font-medium text-brand-orange transition relative group">
                            Pricing
                            <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-brand-orange transition-all"></span>
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

    <!-- Pricing Section -->
    <div class="pt-40 pb-20 relative min-h-screen flex items-center">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
             <div class="absolute top-20 left-1/4 w-[500px] h-[500px] bg-blue-900/20 rounded-full mix-blend-screen filter blur-[120px] animate-pulse"></div>
             <div class="absolute bottom-40 right-1/4 w-[400px] h-[400px] bg-orange-600/20 rounded-full mix-blend-screen filter blur-[120px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="text-center mb-16 reveal active">
                <h2 class="text-brand-orange font-bold tracking-wider uppercase text-sm mb-4">Membership Plans</h2>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6">Choose Your <span class="gradient-text">Path to Success</span></h1>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">Unlock exclusive access to our curriculum, live signals, and mentor support.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-8 items-stretch">
                @foreach ($plans as $plan)
                    <div class="glass-card p-8 rounded-3xl border border-white/10 hover:border-brand-orange/50 transition duration-300 flex flex-col relative overflow-hidden group tilt-card w-full max-w-sm {{ $plan->is_popular ? 'transform scale-105 z-10 shadow-[0_0_40px_rgba(255,159,28,0.15)] border-brand-orange/30' : '' }}">
                        @if($plan->is_popular)
                             <div class="absolute top-0 right-0 bg-brand-orange text-white text-xs font-bold px-4 py-1 rounded-bl-xl shadow-lg animate-pulse">MOST POPULAR</div>
                        @endif
                        
                        <h3 class="text-2xl font-bold text-white mb-4">{{ $plan->name }}</h3>
                        
                        <div class="flex items-start mb-6">
                            <span class="text-lg text-brand-orange font-bold mt-2 mr-1">IDR</span>
                            <span class="text-5xl font-extrabold text-white tracking-tight">{{ number_format($plan->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="text-gray-400 text-sm font-medium mb-8 -mt-4">
                             {{ $plan->billing_cycle === 'lifetime' ? 'One-time payment' : 'Billed ' . $plan->billing_cycle }}
                        </div>
                        
                        <div class="h-px bg-white/10 w-full mb-8"></div>
                        
                        <ul class="space-y-4 mb-8 flex-1">
                            @if($plan->features)
                                @foreach ($plan->features as $feature => $description)
                                    <li class="flex items-start">
                                        <div class="bg-brand-orange/20 rounded-full p-1 mr-3 mt-1 flex-shrink-0">
                                            <svg class="w-3 h-3 text-brand-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-white font-bold text-base">{{ $feature }}</span>
                                            <span class="text-gray-400 text-xs leading-relaxed">{{ $description }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <a href="{{ route('checkout', $plan) }}" class="relative overflow-hidden block w-full {{ $plan->is_popular ? 'bg-brand-orange hover:bg-orange-600 text-white shadow-[0_0_20px_rgba(255,159,28,0.4)]' : 'bg-white/5 hover:bg-white/10 text-white border border-white/10' }} text-center font-bold py-4 rounded-xl transition duration-300 transform hover:-translate-y-1 group/btn">
                            <span class="relative z-10">Select Plan</span>
                            @if($plan->is_popular)
                                <div class="absolute inset-0 -translate-x-full group-hover/btn:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent z-0"></div>
                            @endif
                        </a>
                        

                    </div>
                @endforeach
            </div>
            
            <div class="mt-16 text-center reveal">
                <div class="flex justify-center gap-4 mt-4 opacity-50 grayscale hover:grayscale-0 transition duration-500">
                    <!-- Payment Icons Placeholders -->
                    <div class="h-8 w-12 bg-white/10 rounded"></div>
                    <div class="h-8 w-12 bg-white/10 rounded"></div>
                    <div class="h-8 w-12 bg-white/10 rounded"></div>
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
        setInterval(fetchCryptoPrices, 60000);

        // Scroll Reveal & Tilt Script
        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('.reveal');

            function checkReveal() {
                const triggerBottom = window.innerHeight / 5 * 4;

                reveals.forEach(reveal => {
                    const revealTop = reveal.getBoundingClientRect().top;
                    if (revealTop < triggerBottom) {
                        reveal.classList.add('active');
                    }
                });
            }

            // 3D Tilt Effect
            const cards = document.querySelectorAll('.tilt-card');
            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateX = ((y - centerY) / centerY) * -5;
                    const rotateY = ((x - centerX) / centerX) * 5;

                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = ''; 
                });
            });

            window.addEventListener('scroll', checkReveal);
            checkReveal();
        });
    </script>

</body>
</html>

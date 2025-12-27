<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pividiar Capital') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800" rel="stylesheet" />

        <!-- Scripts -->
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
            }

            .gradient-text {
                background: linear-gradient(to right, #FF9F1C, #FFD700);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-brand-dark text-white selection:bg-brand-orange selection:text-white">
        <div class="min-h-screen bg-brand-dark">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="glass sticky top-0 z-40">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
    </body>
</html>

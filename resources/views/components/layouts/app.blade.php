<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RIAK AIR GUCI - {{ $title ?? 'The Golden Heritage' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FEFAE0;
            /* Rocket Fuel */
            color: #283618;
            /* Ceylanite */
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        .font-heritage {
            font-family: 'Playfair Display', serif;
        }

        /* Navigated Progress Bar Customization */
        .livewire-progress-bar {
            height: 3px !important;
            background-color: #BC6C25 !important;
            box-shadow: 0 0 10px rgba(188, 108, 37, 0.4);
        }

        /* Preloader Animation */
        @keyframes loading-line {
            0% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .animate-loading {
            animation: loading-line 2s ease-in-out infinite;
        }

        /* Smooth Image Loading Effect */
        img {
            transition: filter 0.5s ease-in-out, opacity 0.5s ease-in-out;
        }

        img[loading] {
            filter: blur(10px);
            opacity: 0;
        }
    </style>
</head>

<body class="antialiased" x-data="{ pageLoading: true }" x-init="window.onload = () => { setTimeout(() => pageLoading = false, 1000) }">

    <div x-show="pageLoading" x-transition:leave="transition ease-in duration-800"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[999] bg-[#FEFAE0] flex flex-col items-center justify-center">

        <div class="relative flex flex-col items-center">
            <h2 class="text-3xl md:text-5xl text-[#283618] tracking-[0.4em] mb-6 animate-pulse uppercase">
                Riak Air Guci
            </h2>

            <div class="w-64 h-[1px] bg-[#283618]/10 relative overflow-hidden rounded-full">
                <div class="absolute inset-0 bg-[#BC6C25] animate-loading"></div>
            </div>

            <p class="mt-8 text-[9px] uppercase tracking-[0.6em] text-[#BC6C25] font-black italic">
                {{ __('Refining Heritage') }}
            </p>
        </div>
    </div>

    <livewire:layout.navbar />

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <footer class="bg-[#283618] text-[#FEFAE0] py-20 px-6 border-t border-[#DDA15E]/10">
        <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-16">
            <div class="md:col-span-2">
                <h3 class="text-3xl font-heritage mb-6 text-[#DDA15E] italic">Riak Air Guci</h3>
                <p class="text-sm opacity-70 leading-[2] max-w-sm font-light">
                    {{ __('Menjembatani warisan emas sulaman tradisional Banjar dengan estetika modern untuk panggung dunia.') }}
                </p>
            </div>

            <div>
                <h4 class="font-bold uppercase tracking-[0.3em] text-[10px] mb-8 text-[#BC6C25]">{{ __('Navigation') }}
                </h4>
                <ul class="space-y-4 text-xs tracking-widest uppercase">
                    <li><a href="{{ route('heritage') }}" wire:navigate
                            class="hover:text-[#DDA15E] transition-colors">{{ __('The Heritage') }}</a></li>
                    <li><a href="/gallery" wire:navigate
                            class="hover:text-[#DDA15E] transition-colors">{{ __('The Gallery') }}</a></li>
                    <li><a href="/movement" wire:navigate
                            class="hover:text-[#DDA15E] transition-colors">{{ __('The Movement') }}</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold uppercase tracking-[0.3em] text-[10px] mb-8 text-[#BC6C25]">{{ __('Connect') }}
                </h4>
                <div class="space-y-2 text-sm opacity-70 font-light">
                    <p>Pusaka Banua Collective</p>
                    <p>Banjarmasin, South Kalimantan</p>
                    <p class="pt-4 text-[#DDA15E] font-medium">info@riakairguci.com</p>
                </div>
            </div>
        </div>

        <div
            class="max-w-7xl mx-auto mt-20 pt-8 border-t border-[#606C38]/20 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] uppercase tracking-[0.2em] opacity-40">
                &copy; {{ date('Y') }} RIAK AIR GUCI. Global Market Ready.
            </p>
            <div class="flex gap-6 opacity-40 text-[10px] uppercase tracking-[0.2em]">
                <a href="#" class="hover:opacity-100 transition">Privacy</a>
                <a href="#" class="hover:opacity-100 transition">Terms</a>
            </div>
        </div>
    </footer>

    <div class="fixed bottom-10 right-10 z-[100]">
        <a href="https://wa.me/628123456789" target="_blank"
            class="group relative flex items-center justify-center p-0 transition-all duration-500">

            <span
                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#BC6C25]/20 opacity-75"></span>

            <div
                class="relative flex items-center bg-[#283618]/90 backdrop-blur-xl border border-[#DDA15E]/20 text-[#FEFAE0] px-6 py-4 rounded-full shadow-2xl transition-all duration-500 group-hover:bg-[#BC6C25] group-hover:shadow-[0_20px_40px_-15px_rgba(188,108,37,0.5)]">

                <svg class="w-5 h-5 transition-transform duration-500 group-hover:rotate-[15deg] group-hover:scale-110"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>

                <div
                    class="max-w-0 overflow-hidden flex flex-col items-start transition-all duration-700 ease-in-out group-hover:max-w-xs group-hover:ml-4">
                    <span
                        class="text-[7px] uppercase tracking-[0.4em] whitespace-nowrap text-[#DDA15E] leading-none mb-1">
                        {{ __('Concierge') }}
                    </span>
                    <span class="whitespace-nowrap text-[10px] font-bold uppercase tracking-[0.2em]">
                        {{ __('Inquiry Now') }}
                    </span>
                </div>
            </div>
        </a>
    </div>

    @livewireScripts
</body>

</html>

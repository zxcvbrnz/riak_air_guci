<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RIAK AIR GUCI - {{ $title ?? 'The Golden Heritage' }}</title>

    <link rel="shortcut icon" href="{{ asset('IMG_7179 (1).PNG') }}" type="image/x-icon">
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
            /* Spring Cream */
            color: #2E3317;
            /* Royal Army */
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        .font-heritage {
            font-family: 'Playfair Display', serif;
        }

        /* Progress Bar: Honey Quartz */
        .livewire-progress-bar {
            height: 3px !important;
            background-color: #F7B720 !important;
            box-shadow: 0 0 15px rgba(247, 183, 32, 0.4);
        }

        @keyframes loading-line {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .animate-loading {
            animation: loading-line 2s ease-in-out infinite;
        }

        /* Custom Selection Color */
        ::selection {
            background-color: rgba(247, 183, 32, 0.3);
            color: #2E3317;
        }
    </style>
</head>

<body class="antialiased selection:bg-riak-honey/30" x-data="{ pageLoading: true }" x-init="window.onload = () => { setTimeout(() => pageLoading = false, 800) }">

    <div x-show="pageLoading" x-transition:leave="transition ease-in duration-800"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[999] bg-riak-cream flex flex-col items-center justify-center overflow-hidden">

        <style>
            @keyframes ripple-out {
                0% {
                    transform: scale(0.3);
                    opacity: 0;
                }

                20% {
                    opacity: 0.5;
                }

                100% {
                    transform: scale(1.5);
                    opacity: 0;
                }
            }

            .ripple-ring {
                position: absolute;
                border: 1px solid #F7B720;
                /* Honey Quartz */
                border-radius: 50%;
                opacity: 0;
                animation: ripple-out 3s cubic-bezier(0.23, 1, 0.32, 1) infinite;
            }
        </style>

        <div class="relative flex flex-col items-center">
            <div class="relative w-40 h-40 flex items-center justify-center mb-12">
                <div class="ripple-ring w-full h-full" style="animation-delay: 0s"></div>
                <div class="ripple-ring w-full h-full" style="animation-delay: 0.8s"></div>
                <div class="ripple-ring w-full h-full" style="animation-delay: 1.6s"></div>
                <div class="w-2 h-2 bg-riak-army rounded-full opacity-40"></div>
            </div>

            <h2 class="text-riak-army tracking-[0.8em] mb-4 uppercase font-heritage font-light text-center pl-[0.8em]">
                Riak Air Guci
            </h2>

            <div class="w-24 h-[1px] bg-riak-khaki/10 relative overflow-hidden">
                <div class="absolute inset-0 bg-riak-honey animate-loading"></div>
            </div>

            <p
                class="mt-5 text-[8px] uppercase tracking-[0.5em] text-riak-khaki font-bold italic opacity-80 pl-[0.5em]">
                @id
                    Menyempurnakan Warisan
                @endid @en Refining Heritage @enden
            </p>
        </div>
    </div>

    <livewire:layout.navbar />

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <footer class="bg-riak-army text-riak-cream py-24 px-6 border-t border-riak-khaki/10">
        <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-16">
            <div class="md:col-span-2">
                <h3 class="text-3xl font-heritage mb-6 text-riak-honey italic">Riak Air Guci</h3>
                <p class="text-sm opacity-70 leading-[2] max-w-sm font-light">
                    @id
                        Mengalirkan marwah sulam manik emas Banjar dari tepian sungai ke panggung dunia, menciptakan harmoni
                        dalam setiap detail warisan.
                    @endid
                    @en Channeling the spirit of Banjar gold bead embroidery from the riverbank to the world stage,
                    creating harmony in every heritage detail.
                    @enden
                </p>
            </div>

            <div>
                <h4 class="font-bold uppercase tracking-[0.3em] text-[10px] mb-8 text-riak-persimmon">
                    @id
                        Navigasi
                    @endid @en Navigation @enden
                </h4>
                <ul class="space-y-4 text-xs tracking-widest uppercase">
                    <li><a href="{{ route('home') }}" wire:navigate class="hover:text-riak-honey transition-colors">
                            @id
                                Beranda
                            @endid @en Home @enden
                        </a></li>
                    <li><a href="{{ route('heritage') }}" wire:navigate class="hover:text-riak-honey transition-colors">
                            @id
                                Warisan
                            @endid @en The Heritage @enden
                        </a></li>
                    <li><a href="{{ route('gallery') }}" wire:navigate class="hover:text-riak-honey transition-colors">
                            @id
                                Koleksi
                            @endid @en The Gallery @enden
                        </a></li>
                    <li><a href="{{ route('movement') }}" wire:navigate class="hover:text-riak-honey transition-colors">
                            @id
                                Gerakan
                            @endid @en The Movement @enden
                        </a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold uppercase tracking-[0.3em] text-[10px] mb-8 text-riak-persimmon">
                    @id
                        Hubungi
                    @endid @en Connect @enden
                </h4>
                <div class="space-y-2 text-sm opacity-70 font-light">
                    <p class="font-medium text-riak-cream">Pusaka Banua</p>
                    <p>Banjarmasin, Kalimantan Selatan</p>
                    <a href="mailto:pusakabanua.id@gmail.com"
                        class="pt-4 block text-riak-honey font-medium hover:text-riak-persimmon transition-colors">pusakabanua.id@gmail.com</a>
                </div>
            </div>
        </div>

        <div
            class="max-w-7xl mx-auto mt-20 pt-8 border-t border-riak-cream/10 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] uppercase tracking-[0.2em] opacity-40">
                &copy; {{ date('Y') }} RIAK AIR GUCI. @id
                    Semua hak cipta dilindungi.
                @endid @en All rights reserved. @enden
            </p>
            <div class="flex gap-6 opacity-40 text-[10px] uppercase tracking-[0.2em]">
                <a href="#" class="hover:text-riak-honey transition">
                    @id
                        Privasi
                    @endid @en Privacy @enden
                </a>
                <a href="#" class="hover:text-riak-honey transition">
                    @id
                        Ketentuan
                    @endid @en Terms @enden
                </a>
            </div>
        </div>
    </footer>

    <div class="fixed bottom-10 right-10 z-[100]">
        <a href="https://wa.me/6285249558488" target="_blank"
            class="group relative flex items-center justify-center p-0 transition-all duration-500">

            <span
                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-riak-honey/20 opacity-75"></span>

            <div
                class="relative flex items-center bg-riak-army/90 backdrop-blur-xl border border-riak-khaki/20 text-riak-cream px-6 py-4 rounded-full shadow-2xl transition-all duration-500 group-hover:bg-riak-khaki">

                <svg class="w-5 h-5 text-riak-honey transition-transform duration-500 group-hover:rotate-[15deg] group-hover:scale-110"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>

                <div
                    class="max-w-0 overflow-hidden flex flex-col items-start transition-all duration-700 ease-in-out group-hover:max-w-xs group-hover:ml-4">
                    <span
                        class="text-[7px] uppercase tracking-[0.4em] whitespace-nowrap text-riak-honey leading-none mb-1">
                        @id
                            Layanan Concierge
                        @endid @en Concierge Service @enden
                    </span>
                    <span class="whitespace-nowrap text-[10px] font-bold uppercase tracking-[0.2em]">
                        @id
                            Tanya Sekarang
                        @endid @en Inquiry Now @enden
                    </span>
                </div>
            </div>
        </a>
    </div>

    @livewireScripts
</body>

</html>

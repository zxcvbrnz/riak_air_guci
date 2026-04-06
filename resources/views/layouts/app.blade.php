<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Riak Admin') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Scrollbar untuk Sidebar agar tetap estetik */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(221, 161, 94, 0.2);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(221, 161, 94, 0.5);
        }
    </style>
</head>

<body class="font-sans antialiased bg-[#FEFAE0]/30 text-[#283618]">
    <div class="flex flex-col lg:flex-row h-screen overflow-hidden">

        <livewire:layout.navigation />
        {{-- @livewire('layout.navigation') --}}

        <div class="flex-grow flex flex-col min-w-0 overflow-y-auto custom-scrollbar">

            @if (isset($header))
                <header class="bg-white border-b border-[#DDA15E]/10 py-6 px-6 lg:px-10 sticky top-0 z-20">
                    <div class="max-w-7xl mx-auto">
                        <h2 class="font-serif italic text-2xl text-[#283618] leading-tight">
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endif

            <main class="p-6 lg:p-10">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>

            <footer class="mt-auto py-6 px-10 text-[10px] text-[#283618]/30 uppercase tracking-[0.2em] text-right">
                &copy; {{ date('Y') }} Riak Air Guci &bull; Admin Panel
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>

</html>

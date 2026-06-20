<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Riak Air Guci</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased" x-data="{ appLocale: '{{ app()->getLocale() }}' }">

    {{-- Tombol Ganti Bahasa (Pojok Kanan Atas) --}}
    <div
        class="absolute top-5 right-5 flex items-center gap-2 border border-riak-army/10 bg-white/80 backdrop-blur-sm px-3 py-1.5 rounded-sm shadow-sm transition-colors duration-300">
        <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'id'])) }}"
            class="text-[10px] font-black tracking-wider transition-colors"
            :class="appLocale == 'id' ? 'text-riak-honey' : 'text-riak-army/50 hover:text-riak-army'">
            ID
        </a>
        <span class="text-[10px] text-riak-army/20 select-none">|</span>
        <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}"
            class="text-[10px] font-black tracking-wider transition-colors"
            :class="appLocale == 'en' ? 'text-riak-honey' : 'text-riak-army/50 hover:text-riak-army'">
            EN
        </a>
    </div>

    {{-- Konten Utama --}}
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-16 sm:pt-0 bg-gray-100">
        <div>
            <a href="/" wire:navigate>
                <img src="{{ asset('IMG_7179 (1).PNG') }}" alt="Logo" class="w-20 h-20 object-contain">
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>

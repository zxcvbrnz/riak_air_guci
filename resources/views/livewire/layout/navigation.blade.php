<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logouts(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div x-data="{ open: false }" class="shrink-0 shadow-xl z-50">
    <div class="lg:hidden flex items-center justify-between bg-white px-4 py-3 border-b border-gray-100">
        <img src="{{ asset('IMG_7179 (1).PNG') }}" alt="" class="block h-10 w-auto fill-current text-gray-800">
        <button @click="open = !open" class="p-2 rounded-md text-gray-400 hover:bg-gray-100">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <aside :class="{ 'translate-x-0': open, '-translate-x-full': !open }"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-[#283618] text-white transition-transform duration-300 transform lg:translate-x-0 lg:relative lg:inset-0 h-full flex flex-col shadow-xl">
        <div class="flex
        flex-col h-full">
            <div class="flex items-center justify-center h-20 border-b border-white/10">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3">
                    {{-- <x-application-logo class="h-10 w-auto fill-current text-[#DDA15E]" /> --}}
                    <img src="{{ asset('IMG_7179 (1).PNG') }}" alt="" class=" h-14 w-auto">
                    <span class="font-serif italic text-xl tracking-wider text-[#FEFAE0]">Admin Panel</span>
                </a>
            </div>

            <nav class="flex-grow px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar overflow-x-hidden">

                <div class="pb-4">
                    <p class="px-4 text-[10px] font-bold uppercase tracking-[0.3em] text-[#DDA15E]/60 mb-4">Menu Utama
                    </p>

                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        icon="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
                        Dashboard
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('trip.index')" :active="request()->routeIs('trip.*')"
                        icon="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z M3 5.25a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v13.5a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V5.25Z">
                        Kelola Trip
                    </x-sidebar-link>
                </div>

                <div class="pb-4">
                    <p class="px-4 text-[10px] font-bold uppercase tracking-[0.3em] text-[#DDA15E]/60 mb-4">Media &
                        Produk</p>

                    <x-sidebar-link :href="route('video.index')" :active="request()->routeIs('video.*')"
                        icon="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z">
                        Video
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('motif.index')" :active="request()->routeIs('motif.*')"
                        icon="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.127Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1-1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42">
                        Motif
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('product.index')" :active="request()->routeIs('product.*')"
                        icon="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z">
                        Produk
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('creative-kit.index')" :active="request()->routeIs('creative-kit.*')"
                        icon="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-10.5v10.5">
                        Creative Kits
                    </x-sidebar-link>
                </div>

                <div class="pb-4">
                    <p class="px-4 text-[10px] font-bold uppercase tracking-[0.3em] text-[#DDA15E]/60 mb-4">Gerakan &
                        Sekolah</p>

                    <x-sidebar-link :href="route('movement-school.index')" :active="request()->routeIs('movement-school.*')"
                        icon="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z">
                        Movement School
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('artisan.index')" :active="request()->routeIs('artisan.*')"
                        icon="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z">
                        Artisan
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('internal-schedule.index')" :active="request()->routeIs('internal-schedule.*')"
                        icon="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5">
                        Jadwal Internal
                    </x-sidebar-link>
                </div>
            </nav>

            <div class="p-4 border-t border-white/10 bg-[#1a2310]">
                <div class="flex items-center gap-3 px-4 py-3">
                    <div
                        class="w-8 h-8 rounded-full bg-[#BC6C25] flex items-center justify-center text-white font-bold text-xs">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-grow overflow-hidden">
                        <p class="text-xs font-bold text-[#FEFAE0] truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-[#DDA15E]/60 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="mt-2 space-y-1">
                    <a href="{{ route('profile') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-[#FEFAE0]/70 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil
                    </a>
                    <button wire:click="logouts"
                        class="w-full flex items-center gap-3 px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-red-400 hover:text-red-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </div>
            </div>
        </div>
    </aside>

    <div x-show="open" @click="open = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        x-transition:enter="transition opacity-ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition opacity-ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
</div>

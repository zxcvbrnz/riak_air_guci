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
    {{-- Header Responsif Mobile --}}
    <div class="lg:hidden flex items-center justify-between bg-white px-4 py-3 border-b border-gray-100">
        <img src="{{ asset('IMG_7179 (1).PNG') }}" alt="Logo" class="block h-10 w-auto fill-current text-gray-800">
        <button @click="open = !open" class="p-2 rounded-md text-gray-400 hover:bg-gray-100 focus:outline-none">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Sidebar Drawer Utama --}}
    <aside :class="{ 'translate-x-0': open, '-translate-x-full': !open }"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-[#283618] text-white transition-transform duration-300 transform lg:translate-x-0 lg:relative lg:inset-0 h-full flex flex-col shadow-xl">

        <div class="flex flex-col h-full">
            {{-- Bagian Branding / Logo --}}
            <div class="flex items-center justify-center h-20 border-b border-white/10">
                <a href="#" wire:navigate class="flex items-center gap-3">
                    <img src="{{ asset('IMG_7179 (1).PNG') }}" alt="Logo Panel" class="h-14 w-auto">
                    <span class="font-serif italic text-xl tracking-wider text-[#FEFAE0]">
                        {{ auth()->user()->role === 'admin' ? 'Admin' : 'User' }} Panel
                    </span>
                </a>
            </div>

            {{-- Bagian List Navigasi Menu --}}
            <nav class="flex-grow px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar overflow-x-hidden">

                {{-- Group: Menu Utama --}}
                <div class="pb-4">
                    <p class="px-4 text-[10px] font-bold uppercase tracking-[0.3em] text-[#DDA15E]/60 mb-4">Menu Utama
                    </p>

                    {{-- Dashboard (Admin / User) --}}
                    <x-sidebar-link :href="auth()->user()->role === 'admin' ? route('dashboard.admin') : route('dashboard.user')" :active="auth()->user()->role === 'admin' ? request()->routeIs('dashboard.admin') : request()->routeIs('dashboard.user')"
                        icon="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
                        Dashboard
                    </x-sidebar-link>

                    {{-- Upload Karya (Khusus User dengan tipe paket 'kit') --}}
                    @if (auth()->user()->role === 'user' && auth()->user()->member?->uniqueCode?->type === 'kit')
                        <x-sidebar-link :href="route('upload-karya')" :active="request()->routeIs('upload-karya')"
                            icon="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5h10.5a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0017.25 4.5H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25z">
                            Upload Karya
                        </x-sidebar-link>
                    @endif

                    {{-- Fitur Khusus Admin --}}
                    @if (auth()->user()->role === 'admin')
                        <x-sidebar-link :href="route('user.index')" :active="request()->routeIs('user.*')"
                            icon="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z">
                            Kelola User
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('trip.index')" :active="request()->routeIs('trip.*')"
                            icon="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25M3 14.25h16.5M5.25 14.25V6.375c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125V14.25m-13.5 0h13.5">
                            Kelola Trip
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('verifikasi-karya.index')" :active="request()->routeIs('verifikasi-karya.*')"
                            icon="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z">
                            Verifikasi Karya
                        </x-sidebar-link>
                    @endif
                </div>

                {{-- Group: Media & Produk (Admin Only) --}}
                @if (auth()->user()->role === 'admin')
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

                    {{-- Group: Gerakan & Sekolah (Admin Only) --}}
                    <div class="pb-4">
                        <p class="px-4 text-[10px] font-bold uppercase tracking-[0.3em] text-[#DDA15E]/60 mb-4">Gerakan
                            & Sekolah</p>

                        <x-sidebar-link :href="route('movement-school.index')" :active="request()->routeIs('movement-school.*')"
                            icon="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z">
                            Movement School
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('artisan.index')" :active="request()->routeIs('artisan.*')"
                            icon="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z">
                            Maestro
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('internal-schedule.index')" :active="request()->routeIs('internal-schedule.*')"
                            icon="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5">
                            Jadwal Internal
                        </x-sidebar-link>
                    </div>
                @endif
            </nav>

            {{-- Bagian Informasi User & Pengaturan Akun di Bawah --}}
            <div class="p-4 border-t border-white/10 bg-[#1a2310]">
                <div class="flex items-center gap-3 px-4 py-3">
                    <div
                        class="w-8 h-8 rounded-full bg-[#BC6C25] flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow overflow-hidden">
                        <p class="text-xs font-bold text-[#FEFAE0] truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-[#DDA15E]/60 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="mt-2 space-y-1">
                    <a href="{{ route('profile') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-[#FEFAE0]/70 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil
                    </a>
                    <button wire:click="logouts"
                        class="w-full flex items-center gap-3 px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-red-400 hover:text-red-300 transition-colors focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </div>
            </div>
        </div>
    </aside>

    {{-- Backdrop Overlay Dim saat Mobile Open --}}
    <div x-show="open" @click="open = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        x-transition:enter="transition opacity ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition opacity ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
</div>

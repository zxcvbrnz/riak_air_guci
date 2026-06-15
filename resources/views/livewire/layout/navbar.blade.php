<nav x-data="{
    atTop: true,
    mobileMenu: false,
    profileDropdown: false,
    /* State baru untuk dropdown profil */
    appLocale: '{{ app()->getLocale() }}',
    isHome: {{ Route::is('home') || Route::is('artisan.show') || Route::is('trip.show') ? 'true' : 'false' }},
    scrollHandler() {
        this.atTop = window.pageYOffset < 50;
    }
}" x-init="scrollHandler()" @scroll.window="scrollHandler()"
    :class="atTop ? 'bg-transparent border-transparent py-8' :
        'bg-white/90 backdrop-blur-xl border-riak-army/5 shadow-[0_4px_30px_rgba(0,0,0,0.03)] py-5'"
    class="fixed top-0 w-full z-[100] transition-all duration-500 ease-in-out border-b px-6 md:px-12">

    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="group cursor-pointer">
            <a href="{{ route('home') }}" wire:navigate class="block">
                <h1 class="font-serif text-xl md:text-2xl tracking-[0.2em] transition-colors duration-500"
                    :class="atTop ? (isHome ? 'text-riak-cream' : 'text-riak-army') : 'text-riak-army'">
                    RIAK AIR GUCI
                </h1>
                <div class="h-[1px] bg-riak-honey transition-all duration-500"
                    :class="atTop ? 'w-0 group-hover:w-full' : 'w-full'"></div>
            </a>
        </div>

        <div class="hidden md:flex items-center gap-8">
            <div class="flex gap-8 text-[10px] uppercase tracking-[0.2em] font-bold transition-colors duration-500"
                :class="atTop ? (isHome ? 'text-riak-cream' : 'text-riak-army/80') : 'text-riak-army/80'">

                <a href="{{ route('home') }}" wire:navigate
                    class="transition-colors {{ Route::is('home') ? 'text-riak-honey' : 'hover:text-riak-honey' }}">
                    @id
                        Beranda
                    @endid @en Home @enden
                </a>
                <a href="{{ route('heritage') }}" wire:navigate
                    class="transition-colors {{ Route::is('heritage') ? 'text-riak-honey' : 'hover:text-riak-honey' }}">
                    @id
                        Warisan
                    @endid @en The Heritage @enden
                </a>
                <a href="{{ route('gallery') }}" wire:navigate
                    class="transition-colors {{ Route::is('gallery') ? 'text-riak-honey' : 'hover:text-riak-honey' }}">
                    @id
                        Koleksi
                    @endid @en The Gallery @enden
                </a>
                <a href="{{ route('movement') }}" wire:navigate
                    class="transition-colors {{ Route::is('movement') ? 'text-riak-honey' : 'hover:text-riak-honey' }}">
                    @id
                        Gerakan
                    @endid @en The Movement @enden
                </a>
            </div>

            <div class="flex items-center gap-3 border-l pl-8 transition-colors duration-500"
                :class="atTop ? (isHome ? 'border-riak-cream/20' : 'border-riak-army/10') : 'border-riak-army/10'">
                <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'id'])) }}"
                    class="text-[10px] font-black transition-colors"
                    :class="appLocale == 'id' ? 'text-riak-honey' : (atTop ? (isHome ? 'text-riak-cream' :
                        'text-riak-army/50') : 'text-riak-army/50')">
                    ID
                </a>
                <span class="text-[10px] opacity-30"
                    :class="atTop ? (isHome ? 'text-riak-cream' : 'text-riak-army') : 'text-riak-army'">|</span>
                <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}"
                    class="text-[10px] font-black transition-colors"
                    :class="appLocale == 'en' ? 'text-riak-honey' : (atTop ? (isHome ? 'text-riak-cream' :
                        'text-riak-army/50') : 'text-riak-army/50')">
                    EN
                </a>
            </div>

            <div class="flex items-center gap-4 text-[10px] uppercase tracking-[0.2em] font-bold border-l pl-8 transition-colors duration-500 relative"
                :class="atTop ? (isHome ? 'border-riak-cream/20' : 'border-riak-army/10') : 'border-riak-army/10'">

                @guest
                    <a href="{{ route('login') }}" wire:navigate class="transition-colors"
                        :class="atTop ? (isHome ? 'text-riak-cream hover:text-riak-honey' :
                            'text-riak-army/80 hover:text-riak-honey') : 'text-riak-army/80 hover:text-riak-honey'">
                        Login
                    </a>

                    <a href="{{ route('register') }}" wire:navigate
                        class="px-4 py-2 border transition-all duration-300 rounded-sm"
                        :class="atTop ? (isHome ? 'border-riak-cream text-riak-cream hover:bg-riak-cream hover:text-riak-army' :
                                'border-riak-army text-riak-army hover:bg-riak-army hover:text-riak-cream') :
                            'border-riak-army text-riak-army hover:bg-riak-army hover:text-riak-cream'">
                        @id
                            Daftar
                        @endid @en Register @enden
                    </a>
                @endguest

                @auth
                    <button @click="profileDropdown = !profileDropdown" @click.away="profileDropdown = false"
                        class="flex mx-3 text-sm rounded-full focus:ring-2 focus:ring-riak-honey transition-all duration-300 outline-none">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full object-cover border border-riak-honey/30"
                            src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="User photo">
                    </button>

                    <div x-show="profileDropdown" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 transform"
                        x-transition:enter-end="opacity-100 scale-100 transform"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100 transform"
                        x-transition:leave-end="opacity-0 scale-95 transform" x-cloak
                        class="absolute right-0 top-10 mt-2 w-48 bg-white border border-gray-100 rounded-md shadow-lg py-1 z-50 text-left normal-case tracking-normal">

                        <div class="px-4 py-2 border-b border-gray-50">
                            <p class="text-xs font-semibold text-riak-army truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-gray-400 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <a href="{{ auth()->user()->role === 'admin' ? route('dashboard.admin') : route('dashboard.user') }}"
                            wire:navigate
                            class="block px-4 py-2.5 text-xs text-riak-army hover:bg-riak-cream/30 hover:text-riak-honey transition-colors">
                            Dashboard
                        </a>

                        <button wire:click="logouts"
                            class="block w-full text-left px-4 py-2.5 text-xs text-red-500 hover:bg-red-50 transition-colors">
                            @id
                                Keluar
                            @endid @en Logout @enden
                        </button>
                    </div>
                @endauth
            </div>
        </div>

        <button @click="mobileMenu = true" class="md:hidden transition-colors duration-500"
            :class="atTop ? (isHome ? 'text-riak-cream' : 'text-riak-army') : 'text-riak-army'">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 8h16M4 16h16" stroke-width="1.5" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-cloak
        class="fixed inset-0 bg-riak-cream z-[110] flex flex-col items-center justify-center">

        <button @click="mobileMenu = false" class="absolute top-10 right-10 text-riak-army hover:text-riak-honey">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-width="1" stroke-linecap="round" />
            </svg>
        </button>

        <div class="flex flex-col items-center gap-8 font-serif text-3xl text-riak-army">
            <a href="{{ route('home') }}" wire:navigate @click="mobileMenu = false"
                class="{{ Route::is('home') ? 'text-riak-honey' : '' }} hover:text-riak-honey tracking-widest italic">
                @id
                    Beranda
                @endid @en Home @enden
            </a>
            <a href="{{ route('heritage') }}" wire:navigate @click="mobileMenu = false"
                class="{{ Route::is('heritage') ? 'text-riak-honey' : '' }} hover:text-riak-honey tracking-widest italic">
                @id
                    Warisan
                @endid @en The Heritage @enden
            </a>
            <a href="{{ route('gallery') }}" wire:navigate @click="mobileMenu = false"
                class="{{ Route::is('gallery') ? 'text-riak-honey' : '' }} hover:text-riak-honey tracking-widest italic">
                @id
                    Koleksi
                @endid @en The Gallery @enden
            </a>
            <a href="{{ route('movement') }}" wire:navigate @click="mobileMenu = false"
                class="{{ Route::is('movement') ? 'text-riak-honey' : '' }} hover:text-riak-honey tracking-widest italic">
                @id
                    Gerakan
                @endid @en The Movement @enden
            </a>
        </div>

        <div class="mt-12 flex flex-col items-center gap-4 w-64 pt-8 border-t border-riak-army/10">
            @guest
                <a href="{{ route('login') }}" wire:navigate @click="mobileMenu = false"
                    class="text-sm uppercase tracking-[0.2em] font-bold text-riak-army hover:text-riak-honey transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}" wire:navigate @click="mobileMenu = false"
                    class="w-full text-center py-3 text-sm uppercase tracking-[0.2em] font-bold border border-riak-army text-riak-army hover:bg-riak-army hover:text-riak-cream transition-all duration-300">
                    @id
                        Daftar
                    @endid @en Register @enden
                </a>
            @endguest

            @auth
                <div class="flex items-center gap-3 mb-2 self-start w-full px-2">
                    <img class="w-10 h-10 rounded-full object-cover border border-riak-honey"
                        src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}">
                    <div class="text-left">
                        <p class="text-xs font-bold text-riak-army uppercase tracking-wider">{{ auth()->user()->name }}
                        </p>
                        <p class="text-[10px] text-riak-army/60">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <a href="{{ auth()->user()->role === 'admin' ? route('dashboard.admin') : route('dashboard.user') }}"
                    wire:navigate @click="mobileMenu = false"
                    class="w-full text-center py-3 text-sm uppercase tracking-[0.2em] font-bold bg-riak-honey text-white rounded-sm hover:bg-transparent border border-riak-honey hover:text-riak-army transition-all duration-300">
                    Dashboard
                </a>

                <button wire:click="logouts" @click="mobileMenu = false"
                    class="w-full text-center py-2.5 text-xs uppercase tracking-[0.2em] font-bold text-red-500 hover:bg-red-50 transition-colors">
                    @id
                        Keluar
                    @endid @en Logout @enden
                </button>
            @endauth
        </div>
    </div>
</nav>

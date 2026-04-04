<nav x-data="{
    atTop: true,
    mobileMenu: false,
    appLocale: '{{ app()->getLocale() }}',
    isHome: {{ Route::is('home') ? 'true' : 'false' }},
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

        <div class="hidden md:flex items-center gap-10">
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
    </div>
</nav>

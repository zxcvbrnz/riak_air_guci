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
        'bg-white/90 backdrop-blur-xl border-black/5 shadow-[0_4px_30px_rgba(0,0,0,0.03)] py-5'"
    class="fixed top-0 w-full z-[100] transition-all duration-500 ease-in-out border-b px-6 md:px-12">

    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="group cursor-pointer">
            <a href="{{ route('home') }}" wire:navigate class="block">
                <h1 class="font-heritage text-xl md:text-2xl tracking-[0.2em] transition-colors duration-500"
                    :class="atTop ? (isHome ? 'text-[#FEFAE0]' : 'text-[#283618]') : 'text-[#283618]'">
                    RIAK AIR GUCI
                </h1>
                <div class="h-[1px] bg-[#BC6C25] transition-all duration-500"
                    :class="atTop ? 'w-0 group-hover:w-full' : 'w-full'"></div>
            </a>
        </div>

        <div class="hidden md:flex items-center gap-10">
            <div class="flex gap-8 text-[10px] uppercase tracking-[0.2em] font-bold transition-colors duration-500"
                :class="atTop ? (isHome ? 'text-[#FEFAE0]' : 'text-[#283618]/80') : 'text-[#283618]/80'">

                <a href="{{ route('home') }}" wire:navigate
                    class="transition-colors {{ Route::is('home') ? 'text-[#BC6C25]' : 'hover:text-[#BC6C25]' }}">
                    {{ __('Home') }}
                </a>
                <a href="{{ route('heritage') }}" wire:navigate
                    class="transition-colors {{ Route::is('heritage') ? 'text-[#BC6C25]' : 'hover:text-[#BC6C25]' }}">
                    {{ __('The Heritage') }}
                </a>
                <a href="{{ route('gallery') }}" wire:navigate
                    class="transition-colors {{ Route::is('gallery') ? 'text-[#BC6C25]' : 'hover:text-[#BC6C25]' }}">
                    {{ __('The Gallery') }}
                </a>
                <a href="{{ route('movement') }}" wire:navigate
                    class="transition-colors {{ Route::is('movement') ? 'text-[#BC6C25]' : 'hover:text-[#BC6C25]' }}">
                    {{ __('The Movement') }}
                </a>
            </div>

            <div class="flex items-center gap-3 border-l pl-8 transition-colors duration-500"
                :class="atTop ? (isHome ? 'border-[#FEFAE0]/20' : 'border-[#283618]/10') : 'border-[#283618]/10'">
                <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'id'])) }}"
                    class="text-[10px] font-black transition-colors"
                    :class="appLocale == 'id' ? 'text-[#BC6C25]' : (atTop ? (isHome ? 'text-[#FEFAE0]' : 'text-[#283618]/50') :
                        'text-[#283618]/50')">
                    ID
                </a>
                <span class="text-[10px] opacity-30"
                    :class="atTop ? (isHome ? 'text-[#FEFAE0]' : 'text-[#283618]') : 'text-[#283618]'">|</span>
                <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}"
                    class="text-[10px] font-black transition-colors"
                    :class="appLocale == 'en' ? 'text-[#BC6C25]' : (atTop ? (isHome ? 'text-[#FEFAE0]' : 'text-[#283618]/50') :
                        'text-[#283618]/50')">
                    EN
                </a>
            </div>
        </div>

        <button @click="mobileMenu = true" class="md:hidden transition-colors duration-500"
            :class="atTop ? (isHome ? 'text-[#FEFAE0]' : 'text-[#283618]') : 'text-[#283618]'">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 8h16M4 16h16" stroke-width="1.5" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-cloak
        class="fixed inset-0 bg-white z-[110] flex flex-col items-center justify-center">

        <button @click="mobileMenu = false" class="absolute top-10 right-10 text-[#283618] hover:text-[#BC6C25]">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-width="1" stroke-linecap="round" />
            </svg>
        </button>

        <div class="flex flex-col items-center gap-8 font-heritage text-3xl text-[#283618]">
            <a href="{{ route('home') }}" wire:navigate @click="mobileMenu = false"
                class="{{ Route::is('home') ? 'text-[#BC6C25]' : '' }} hover:text-[#BC6C25] tracking-widest">{{ __('Home') }}</a>
            <a href="{{ route('heritage') }}" wire:navigate @click="mobileMenu = false"
                class="{{ Route::is('heritage') ? 'text-[#BC6C25]' : '' }} hover:text-[#BC6C25] tracking-widest">{{ __('The Heritage') }}</a>
            <a href="{{ route('gallery') }}" wire:navigate @click="mobileMenu = false"
                class="{{ Route::is('gallery') ? 'text-[#BC6C25]' : '' }} hover:text-[#BC6C25] tracking-widest">{{ __('The Gallery') }}</a>
            <a href="{{ route('movement') }}" wire:navigate @click="mobileMenu = false"
                class="{{ Route::is('movement') ? 'text-[#BC6C25]' : '' }} hover:text-[#BC6C25] tracking-widest">{{ __('The Movement') }}</a>
        </div>
    </div>
</nav>

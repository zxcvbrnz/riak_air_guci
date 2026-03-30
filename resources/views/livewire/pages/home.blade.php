<div class="bg-white min-h-screen text-[#283618] selection:bg-[#DDA15E]/30 font-sans">
    <header class="relative h-screen flex items-center justify-center overflow-hidden bg-black">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/images/pexels-muhammad-hary-2158336590-36427377.jpg') }}"
                alt="Riak Air Guci Heritage" class="w-full h-full object-cover opacity-80 animate-subtle-zoom">

            <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/20 to-black/60"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto">
            <div class="mb-8 opacity-0 animate-[fadeIn_1s_ease-out_forwards]">
                <span class="text-[#FEFAE0] text-[11px] uppercase tracking-[0.6em] font-bold">
                    Bringing Banjar’s Golden Heritage to the Global Stage
                </span>
                <div class="w-16 h-[1px] bg-[#BC6C25] mx-auto mt-4"></div>
            </div>

            <h1
                class="text-4xl md:text-8xl font-serif font-light text-[#FEFAE0] mb-8 leading-tight opacity-0 animate-[fadeInUp_1.2s_ease-out_0.3s_forwards]">
                RIAK AIR GUCI: THE GOLDEN HERITAGE
            </h1>

            <div class="overflow-hidden mb-16">
                <p
                    class="text-[#DDA15E] uppercase tracking-[0.5em] text-[10px] md:text-xs font-medium opacity-0 animate-[fadeInUp_1.2s_ease-out_0.6s_forwards]">
                    Small Ripples, Big Cultural Waves
                </p>
            </div>

            <div class="opacity-0 animate-[fadeInUp_1.2s_ease-out_0.9s_forwards]">
                <button
                    class="group relative inline-flex items-center justify-center px-12 py-4 overflow-hidden border border-[#DDA15E] rounded-full transition-all duration-500 hover:shadow-[0_10px_30px_-10px_rgba(221,161,94,0.5)]">
                    <div
                        class="absolute inset-0 w-0 bg-[#BC6C25] transition-all duration-500 ease-out group-hover:w-full">
                    </div>

                    <span
                        class="relative flex items-center gap-3 text-[#DDA15E] group-hover:text-[#FEFAE0] text-[11px] uppercase tracking-[0.3em] font-bold transition-colors duration-500">
                        {{ __('Explore the Heritage') }}
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform duration-500 group-hover:translate-x-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 opacity-0 animate-[fadeIn_2s_ease-out_1.5s_forwards]">
            <div class="w-[1px] h-12 bg-[#FEFAE0]/50"></div>
        </div>
    </header>

    <section class="bg-white py-32 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-24 items-center">
            <div class="space-y-8">
                <div>
                    <h2 class="text-[#BC6C25] text-[10px] font-black tracking-[0.4em] uppercase mb-4">Upcycled Elegance
                    </h2>
                    <h3 class="text-5xl font-serif text-[#283618] leading-tight">Small Ripples,<br><span
                            class="italic font-light">Big Cultural Waves</span></h3>
                </div>

                <p class="text-[#606C38] leading-[2] text-sm max-w-md font-light">
                    Kami menggabungkan sulaman emas tradisional dengan pemanfaatan limbah tekstil perca & manik-manik
                    berkualitas untuk menciptakan karya seni yang berkelanjutan.
                </p>

                <a href="#"
                    class="inline-flex items-center gap-4 text-[#BC6C25] text-[11px] font-bold uppercase tracking-widest group">
                    <span class="h-[1px] w-8 bg-[#BC6C25] transition-all group-hover:w-12"></span>
                    Watch Our Journey
                </a>
            </div>

            <div class="relative p-4 bg-white shadow-[0_40px_80px_-20px_rgba(0,0,0,0.05)] rounded-3xl">
                <div
                    class="aspect-[4/5] rounded-2xl overflow-hidden grayscale hover:grayscale-0 transition-all duration-1000">
                    <img src="/assets/movement.jpg"
                        class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-[3s]">
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-32 px-6 overflow-hidden" x-data="{
        activeVideo: 1,
        videos: [
            { id: 1, title: 'The Golden Heritage', category: 'Documentary', duration: '05:20', thumb: '/assets/thumb-1.jpg' },
            { id: 2, title: 'Limbah Karya Process', category: 'Craftsmanship', duration: '03:45', thumb: '/assets/thumb-2.jpg' },
            { id: 3, title: 'Maestro Profile', category: 'Personal Tour', duration: '04:12', thumb: '/assets/thumb-3.jpg' },
            { id: 4, title: 'River Workshop Experience', category: 'Culture', duration: '06:10', thumb: '/assets/thumb-4.jpg' },
            { id: 5, title: 'Global Stage Journey', category: 'Vision', duration: '02:30', thumb: '/assets/thumb-5.jpg' }
        ]
    }">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-[#BC6C25] text-[11px] font-black tracking-[0.5em] uppercase mb-4">
                        {{ __('Digital Tour') }}
                    </h2>
                    <h3 class="text-4xl md:text-6xl font-serif text-[#283618] leading-tight">
                        Watch Our <span class="italic font-light text-[#DDA15E]">Journey</span>
                    </h3>
                </div>

                <div class="flex gap-4">
                    <button @click="$refs.slider.scrollBy({left: -400, behavior: 'smooth'})"
                        class="w-12 h-12 rounded-full border border-[#283618]/10 flex items-center justify-center hover:bg-[#BC6C25] hover:text-white transition-all duration-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="$refs.slider.scrollBy({left: 400, behavior: 'smooth'})"
                        class="w-12 h-12 rounded-full border border-[#283618]/10 flex items-center justify-center hover:bg-[#BC6C25] hover:text-white transition-all duration-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-ref="slider" class="flex gap-8 overflow-x-auto snap-x snap-mandatory no-scrollbar pb-12">
                <template x-for="video in videos" :key="video.id">
                    <div class="min-w-[85%] md:min-w-[45%] lg:min-w-[30%] snap-start group cursor-pointer">
                        <div
                            class="relative aspect-[16/10] rounded-3xl overflow-hidden bg-[#283618] mb-6 shadow-sm group-hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] transition-all duration-700">
                            <img :src="video.thumb"
                                class="w-full h-full object-cover opacity-70 grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">

                            <div class="absolute inset-0 flex items-center justify-center">
                                <div
                                    class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 group-hover:scale-110 transition-all duration-500">
                                    <svg class="w-6 h-6 fill-current ml-1" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>

                            <div class="absolute top-6 right-6 px-3 py-1 rounded-full bg-black/20 backdrop-blur-md border border-white/10 text-[9px] text-white font-bold tracking-widest"
                                x-text="video.duration"></div>
                        </div>

                        <div class="px-2">
                            <span class="text-[#BC6C25] text-[9px] font-black uppercase tracking-[0.3em] mb-2 block"
                                x-text="video.category"></span>
                            <h4 class="text-[#283618] text-lg font-serif italic tracking-wide group-hover:text-[#BC6C25] transition-colors"
                                x-text="video.title"></h4>
                        </div>
                    </div>
                </template>
            </div>

            <div class="w-full h-[1px] bg-[#283618]/5 mt-4 relative">
                <div class="absolute top-0 left-0 h-full bg-[#BC6C25] transition-all duration-500"
                    :style="`width: ${(activeVideo / videos.length) * 100}%`"></div>
            </div>
        </div>
    </section>
</div>

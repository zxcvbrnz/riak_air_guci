<div class="bg-riak-cream min-h-screen text-riak-army selection:bg-riak-honey/30 font-sans">

    <header class="relative h-screen flex items-center justify-center overflow-hidden bg-black">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/images/pexels-muhammad-hary-2158336590-36427377.jpg') }}"
                alt="Riak Air Guci Heritage"
                class="w-full h-full object-cover opacity-60 animate-subtle-zoom transition-all duration-1000">

            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/80"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto">
            <div class="mb-8 opacity-0 animate-[fadeIn_1s_ease-out_forwards]">
                <span class="text-riak-honey text-[11px] uppercase tracking-[0.6em] font-bold">
                    @id
                        Menerbangkan Sayap Warisan Banjar Menuju Dunia
                    @endid
                    @en Bringing Banjar’s Golden Heritage to the Global Stage @enden
                </span>
                <div class="w-16 h-[1px] bg-riak-honey mx-auto mt-4"></div>
            </div>

            <h1
                class="text-4xl md:text-8xl font-serif font-light text-riak-cream mb-8 leading-tight opacity-0 animate-[fadeInUp_1.2s_ease-out_0.3s_forwards]">
                @id
                    RIAK AIR GUCI: WARISAN EMAS
                @endid
                @en RIAK AIR GUCI: THE GOLDEN HERITAGE @enden
            </h1>

            <div class="overflow-hidden mb-16">
                <p
                    class="text-riak-persimmon uppercase tracking-[0.5em] text-[10px] md:text-xs font-medium opacity-0 animate-[fadeInUp_1.2s_ease-out_0.6s_forwards]">
                    @id
                        Setetes Riak, Sejuta Makna Budaya
                    @endid
                    @en One Ripple, A Million Cultural Meanings @enden
                </p>
            </div>

            <div class="opacity-0 animate-[fadeInUp_1.2s_ease-out_0.9s_forwards]">
                <button
                    class="group relative inline-flex items-center justify-center px-12 py-4 overflow-hidden border border-riak-honey rounded-full transition-all duration-500 hover:shadow-[0_10px_30px_-10px_rgba(247,183,32,0.5)]">
                    <div
                        class="absolute inset-0 w-0 bg-riak-honey transition-all duration-500 ease-out group-hover:w-full">
                    </div>

                    <span
                        class="relative flex items-center gap-3 text-riak-honey group-hover:text-riak-army text-[11px] uppercase tracking-[0.3em] font-bold transition-colors duration-500">
                        @id
                            Jelajahi Warisan
                        @endid
                        @en Explore the Heritage @enden
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
            <div class="w-[1px] h-12 bg-riak-honey/50"></div>
        </div>
    </header>

    <section class="bg-riak-cream py-32 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-24 items-center">
            <div class="space-y-8">
                <div>
                    <h2 class="text-riak-khaki text-[10px] font-black tracking-[0.4em] uppercase mb-4">
                        @id
                            Keanggunan Warisan
                        @endid @en Authentic Elegance @enden
                    </h2>
                    <h3 class="text-5xl font-serif text-riak-army leading-tight">
                        @id
                            Setetes Riak,<br><span class="italic font-light text-riak-persimmon">Sejuta Makna Budaya</span>
                        @endid
                        @en One Ripple,<br><span class="italic font-light text-riak-persimmon">A Million Cultural
                            Meanings</span> @enden
                    </h3>
                </div>

                <p class="text-riak-army/80 leading-[2] text-sm max-w-md font-light">
                    @id
                        Kami menghidupkan kembali kemilau harta karun budaya yang hampir punah melalui detail manik emas
                        yang dirangkai secara teliti, menciptakan harmoni antara tradisi lama dan gaya hidup modern.
                    @endid
                    @en We bring the luster of nearly lost cultural treasures back to life through meticulously crafted
                    gold beads, creating a harmony between ancient traditions and modern lifestyles. @enden
                </p>

                <a href="#"
                    class="inline-flex items-center gap-4 text-riak-persimmon text-[11px] font-bold uppercase tracking-widest group">
                    <span class="h-[1px] w-8 bg-riak-persimmon transition-all group-hover:w-12"></span>
                    @id
                        Saksikan Perjalanan Kami
                    @endid @en Watch Our Journey @enden
                </a>
            </div>

            <div class="relative p-4 bg-white shadow-[0_40px_80px_-20px_rgba(109,118,54,0.15)] rounded-3xl">
                <div class="aspect-[4/5] rounded-2xl overflow-hidden">
                    <img src="/assets/movement.jpg"
                        class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-[3s]">
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-riak-honey/10 rounded-full blur-2xl"></div>
            </div>
        </div>
    </section>

    <section class="bg-white py-32 px-6 overflow-hidden" x-data="{
        activeVideo: 1,
        openModal: false,
        currentVideoUrl: '',
        videos: {{ $videos->toJson() }}
    }">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-riak-khaki text-[11px] font-black tracking-[0.5em] uppercase mb-4">
                        @id
                            Jelajahi Digital
                        @endid @en Digital Tour @enden
                    </h2>
                    <h3 class="text-4xl md:text-6xl font-serif text-riak-army leading-tight">
                        @id
                            Saksikan <span class="italic font-light text-riak-honey">Perjalanan Kami</span>
                        @endid
                        @en Watch Our <span class="italic font-light text-riak-honey">Journey</span> @enden
                    </h3>
                </div>

                <div class="flex gap-4">
                    <button @click="$refs.slider.scrollBy({left: -400, behavior: 'smooth'})"
                        class="w-12 h-12 rounded-full border border-riak-army/10 flex items-center justify-center hover:bg-riak-honey hover:text-riak-army transition-all duration-500 hover:border-riak-honey">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="$refs.slider.scrollBy({left: 400, behavior: 'smooth'})"
                        class="w-12 h-12 rounded-full border border-riak-army/10 flex items-center justify-center hover:bg-riak-honey hover:text-white transition-all duration-500 hover:border-riak-honey">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-ref="slider" class="flex gap-8 overflow-x-auto snap-x snap-mandatory no-scrollbar pb-12">
                @forelse ($videos as $video)
                    <div class="min-w-[85%] md:min-w-[45%] lg:min-w-[30%] snap-start group cursor-pointer"
                        @click="openModal = true; currentVideoUrl = '{{ $video->video_url }}'">

                        <div
                            class="relative aspect-[16/10] rounded-3xl overflow-hidden bg-riak-army mb-6 shadow-sm group-hover:shadow-[0_20px_40px_-15px_rgba(46,51,23,0.3)] transition-all duration-700">
                            <img src="{{ asset('storage/' . $video->thumb) }}"
                                class="w-full h-full object-cover opacity-60 group-hover:scale-110 transition-all duration-1000">

                            <div class="absolute inset-0 flex items-center justify-center">
                                <div
                                    class="w-14 h-14 rounded-full bg-riak-cream/20 backdrop-blur-md border border-riak-cream/30 flex items-center justify-center text-riak-honey group-hover:bg-riak-honey group-hover:text-riak-army transition-all duration-500">
                                    <svg class="w-6 h-6 fill-current ml-1" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="px-2">
                            <span
                                class="text-riak-persimmon text-[9px] font-black uppercase tracking-[0.3em] mb-2 block">
                                {{ $video->category }}
                            </span>
                            <h4
                                class="text-riak-army text-lg font-serif italic tracking-wide group-hover:text-riak-honey transition-colors">
                                {{ $video->title }}
                            </h4>
                        </div>
                    </div>
                @empty
                    <div
                        class="w-full py-20 flex flex-col items-center justify-center border-2 border-dashed border-riak-khaki/20 rounded-[3rem] bg-riak-cream/50">
                        <h4 class="font-serif text-riak-khaki text-xl italic mb-2">Belum ada jejak digital.</h4>
                    </div>
                @endforelse
            </div>

            <div class="w-full h-[1px] bg-riak-army/5 mt-4 relative">
                <div class="absolute top-0 left-0 h-full bg-riak-persimmon transition-all duration-500"
                    :style="`width: ${(activeVideo / (videos.length || 1)) * 100}%`"></div>
            </div>
        </div>
    </section>
</div>

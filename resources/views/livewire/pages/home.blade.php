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

    <section class="bg-white py-24 px-6 overflow-hidden" x-data="{
        openModal: false,
        currentVideoUrl: '',
        // Fungsi untuk konversi URL YouTube biasa ke embed
        getEmbedUrl(url) {
            if (!url) return '';
            let videoId = '';
            if (url.includes('v=')) videoId = url.split('v=')[1].split('&')[0];
            else if (url.includes('youtu.be/')) videoId = url.split('youtu.be/')[1];
            return videoId ? `https://www.youtube.com/embed/${videoId}?autoplay=1` : url;
        }
    }">

        <div class="max-w-7xl mx-auto">
            <div class="flex items-end justify-between mb-10 gap-6">
                <div class="max-w-md">
                    <h2 class="text-riak-khaki text-[9px] font-black tracking-[0.4em] uppercase mb-2">Digital Tour</h2>
                    <h3 class="text-3xl font-serif text-riak-army">Saksikan <span
                            class="italic font-light text-riak-honey">Perjalanan</span></h3>
                </div>

                <div class="flex gap-2">
                    <button @click="$refs.slider.scrollBy({left: -300, behavior: 'smooth'})"
                        class="w-10 h-10 rounded-full border border-riak-army/10 flex items-center justify-center hover:bg-riak-honey transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="$refs.slider.scrollBy({left: 300, behavior: 'smooth'})"
                        class="w-10 h-10 rounded-full border border-riak-army/10 flex items-center justify-center hover:bg-riak-honey transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-ref="slider"
                class="flex gap-6 overflow-x-auto snap-x snap-mandatory no-scrollbar pb-8 items-stretch">
                @forelse ($videos as $video)
                    <div class="min-w-[280px] md:min-w-[320px] snap-start group cursor-pointer"
                        @click="currentVideoUrl = getEmbedUrl('{{ $video->video_url }}'); openModal = true">

                        <div
                            class="relative aspect-video rounded-2xl overflow-hidden bg-riak-army mb-4 shadow-sm group-hover:shadow-xl transition-all duration-500">
                            <img src="{{ asset('storage/' . $video->thumb) }}"
                                class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-all duration-700">

                            <div
                                class="absolute inset-0 flex items-center justify-center bg-riak-army/20 group-hover:bg-transparent transition-all">
                                <div
                                    class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-riak-honey group-hover:scale-110 transition-all">
                                    <svg class="w-5 h-5 fill-current ml-1" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>

                            <span
                                class="absolute bottom-3 right-3 px-2 py-1 bg-black/60 backdrop-blur-md rounded text-[9px] text-white font-mono">
                                {{ $video->duration }}
                            </span>
                        </div>

                        <div class="px-1">
                            <p class="text-riak-persimmon text-[8px] font-bold uppercase tracking-widest mb-1">
                                {{ $video->category_id }}</p>
                            <h4
                                class="text-riak-army text-sm font-serif italic leading-snug group-hover:text-riak-honey transition-colors">
                                {{ $video->title_id }}
                            </h4>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>

        <template x-teleport="body">
            <div x-show="openModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-10"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                <div class="absolute inset-0 bg-riak-army/95 backdrop-blur-xl"
                    @click="openModal = false; currentVideoUrl = ''"></div>

                <div class="relative w-full max-w-5xl aspect-video bg-black rounded-3xl overflow-hidden shadow-2xl"
                    x-show="openModal" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">

                    <template x-if="openModal">
                        <iframe :src="currentVideoUrl" class="w-full h-full" frameborder="0"
                            allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
                        </iframe>
                    </template>

                    <button @click="openModal = false; currentVideoUrl = ''"
                        class="absolute top-4 right-4 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </section>
    <section class="bg-white py-24 px-6 border-t border-[#DDA15E]/10">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div class="max-w-xl">
                    <h2 class="text-[#BC6C25] text-[10px] font-bold uppercase tracking-[0.5em] mb-4">
                        @id
                            Agenda Terdekat
                        @endid @en Upcoming Agenda @enden
                    </h2>
                    <h3 class="text-4xl font-serif text-[#283618] italic">
                        @id
                            Langkah Gerak Riak
                        @endid @en Riak's Movement @enden
                    </h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-20 gap-y-12">
                @php $locale = app()->getLocale(); @endphp

                @forelse($schedules as $item)
                    <div
                        class="flex items-start gap-8 group pb-8 border-b border-[#DDA15E]/10 last:border-0 lg:last:border-b">
                        <div class="text-center min-w-[60px]">
                            <span class="block text-2xl font-serif italic text-[#BC6C25]">
                                {{ \Carbon\Carbon::parse($item->date)->format('d') }}
                            </span>
                            <span class="block text-[10px] font-bold uppercase tracking-widest text-[#283618]/40">
                                {{ \Carbon\Carbon::parse($item->date)->translatedFormat('M') }}
                            </span>
                        </div>

                        <div class="flex-grow">
                            <div class="flex items-center gap-3 mb-2">
                                <span
                                    class="w-2 h-2 rounded-full {{ $item->is_completed ? 'bg-gray-300' : 'bg-[#DDA15E] animate-pulse' }}"></span>
                                <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-[#BC6C25]">
                                    {{ $item->{'location_' . $locale} }}
                                </span>
                            </div>
                            <h4
                                class="text-xl font-serif text-[#283618] group-hover:text-[#BC6C25] transition-colors duration-500">
                                {{ $item->{'title_' . $locale} }}
                            </h4>
                        </div>

                        @if ($item->is_completed)
                            <div class="hidden md:block">
                                <span
                                    class="text-[8px] font-bold uppercase border border-gray-200 text-gray-400 px-3 py-1 rounded-full">
                                    Done
                                </span>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-[#283618]/40 italic text-sm">
                        @id
                            Belum ada agenda terjadwal
                        @endid @en No scheduled agenda @enden
                    </p>
                @endforelse
            </div>
        </div>
    </section>
</div>

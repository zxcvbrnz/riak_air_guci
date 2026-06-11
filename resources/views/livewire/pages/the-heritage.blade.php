<div class="bg-white min-h-screen selection:bg-riak-honey/30">

    <header class="pt-40 pb-20 px-6 text-center">
        <div class="max-w-4xl mx-auto">
            <h2
                class="text-riak-honey text-[11px] font-bold uppercase tracking-[0.6em] mb-6 animate-[fadeIn_1s_ease-out]">
                @id
                    Arsip Digital
                @endid
                @en Digital Archive @enden
            </h2>
            <h1 class="text-5xl md:text-7xl font-serif text-riak-army leading-tight mb-8">
                @id
                    Filosofi <span class="italic font-light text-riak-persimmon">Motif</span>
                @endid
                @en Motif <span class="italic font-light text-riak-persimmon">Philosophy</span> @enden
            </h1>
            <p class="text-riak-khaki font-light text-sm md:text-base max-w-2xl mx-auto leading-[2]">
                @id
                    Menelusuri jejak sulaman emas tradisional Banjar. Setiap riak benang dan tata letak manik-manik
                    menyimpan cerita tentang kearifan lokal yang abadi.
                @endid
                @en Tracing the legacy of traditional Banjar gold embroidery. Every twist of thread and arrangement of
                beads holds a story of enduring local wisdom. @enden
            </p>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-6 pb-32 space-y-28">
        @forelse($groupedMotifs as $badge => $motifs)
            <section>

                @if ($badge)
                    <div
                        class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12 border-b border-riak-honey/20 pb-6">
                        <div>
                            <span class="text-riak-honey text-[10px] font-bold uppercase tracking-[0.4em] block mb-2">
                                @id
                                    Kategori Koleksi
                                @endid @en Collection Category @enden
                            </span>
                            <h2 class="text-3xl md:text-4xl font-serif text-riak-army italic tracking-wide">
                                {{ $badge }}
                            </h2>
                        </div>
                        <div class="text-riak-khaki/60 text-xs tracking-wider uppercase font-medium">
                            {{ $motifs->count() }} @id
                                Motif Tersedia
                            @endid @en Motifs Available @enden
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
                    @foreach ($motifs as $motif)
                        <div
                            class="group bg-white rounded-2xl border border-riak-honey/5 p-4 transition-all duration-500 hover:shadow-xl hover:border-riak-honey/20">

                            <div
                                class="relative aspect-[4/5] rounded-xl overflow-hidden bg-riak-cream/30 mb-6 shadow-sm">
                                <img src="{{ asset('storage/' . $motif->image) }}" alt="{{ $motif->name }}"
                                    class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110 {{ $motif->is_upcycled ? 'opacity-80 grayscale group-hover:grayscale-0' : '' }}">
                            </div>

                            <div class="space-y-3 px-1">
                                <h3
                                    class="text-xl md:text-2xl font-serif text-riak-army italic tracking-wide group-hover:text-riak-honey transition-colors">
                                    {{ $motif->name }}
                                </h3>
                                <div class="w-8 h-[1px] bg-riak-honey/60"></div>
                                <p class="text-riak-khaki text-xs md:text-sm leading-[1.7] font-light">
                                    {{ $motif->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

        @empty
            <section class="w-full">
                <div
                    class="col-span-full py-32 flex flex-col items-center justify-center border-2 border-dashed border-riak-honey/20 rounded-[3rem] bg-riak-honey/5 text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-sm mb-8">
                        <svg class="w-10 h-10 text-riak-honey/30" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-serif text-riak-army italic mb-3">
                        @id
                            Arsip belum tersedia
                        @endid
                        @en Archive currently unavailable @enden
                    </h4>
                    <p class="text-riak-khaki text-[11px] uppercase tracking-[0.3em] font-bold opacity-60">
                        @id
                            Kami sedang mengkurasi jejak warisan emas Banjar
                        @endid
                        @en We are currently curating the golden heritage of Banjar @enden
                    </p>
                </div>
            </section>
        @endforelse
    </div>

    <section class="bg-riak-cream py-24 text-center border-t border-riak-honey/10">
        <h4 class="text-riak-honey text-[10px] font-black uppercase tracking-[0.4em] mb-8">
            @id
                Siap Memiliki Potongan Sejarah?
            @endid
            @en Ready to Own a Piece of History? @enden
        </h4>
        <a href="{{ route('gallery') }}" wire:navigate
            class="group relative inline-flex items-center gap-6 text-riak-army font-serif text-2xl italic tracking-widest transition-all">
            @id
                Jelajahi Koleksi
            @endid @en Explore Collection @enden
            <span class="w-12 h-[1px] bg-riak-persimmon transition-all group-hover:w-20"></span>
        </a>
    </section>
</div>

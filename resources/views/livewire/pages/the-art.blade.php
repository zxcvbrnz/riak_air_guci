<div class="bg-white min-h-screen selection:bg-riak-honey/30">

    {{-- HEADER HALAMAN --}}
    <header class="pt-40 pb-20 px-6 text-center">
        <div class="max-w-4xl mx-auto">
            <h2
                class="text-riak-honey text-[11px] font-bold uppercase tracking-[0.6em] mb-6 animate-[fadeIn_1s_ease-out]">
                @id
                    Eksibisi Virtual
                @endid
                @en Virtual Exhibition @enden
            </h2>
            <h1 class="text-5xl md:text-7xl font-serif text-riak-army leading-tight mb-8">
                @id
                    Galeri Ruang <span class="italic font-light text-riak-persimmon">Karya</span>
                @endid
                @en Creators <span class="italic font-light text-riak-persimmon">Showcase</span> @enden
            </h1>
            <p class="text-riak-khaki font-light text-sm md:text-base max-w-2xl mx-auto leading-[2]">
                @id
                    Menelusuri jejak kreativitas dan dedikasi para kreator nusantara. Setiap rakitan komponen,
                    alur logika, dan bentuk mekanik menyimpan cerita tentang inovasi teknologi yang tak terbatas.
                @endid
                @en Tracing the ingenuity and dedication of our creators. Every component assembly,
                logic flow, and mechanical form holds a story of endless technological innovation. @enden
            </p>
        </div>
    </header>

    {{-- KONTEN AREA UTAMA: ITERASI PRODUK KIT --}}
    <div class="max-w-7xl mx-auto px-6 pb-32 space-y-28">
        @forelse($groupedKaryas as $kitName => $karyas)
            <section wire:key="kit-group-{{ Str::slug($kitName) }}">
                {{-- Border Kategori Berdasarkan Nama Creative Kit --}}
                <div
                    class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12 border-b border-riak-honey/20 pb-6">
                    <div>
                        <span class="text-riak-honey text-[10px] font-bold uppercase tracking-[0.4em] block mb-2">
                            @id
                                Kategori Kit
                            @endid @en Kit Category @enden
                        </span>
                        <h2 class="text-3xl md:text-4xl font-serif text-riak-army italic tracking-wide">
                            {{ $kitName }}
                        </h2>
                    </div>
                    <div class="text-riak-khaki/60 text-xs tracking-wider uppercase font-medium">
                        {{ $karyas->count() }} @id
                            Karya Tersedia
                        @endid @en Artworks Available @enden
                    </div>
                </div>

                {{-- Grid Galeri Foto Karya --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
                    @foreach ($karyas as $karya)
                        <div wire:key="karya-item-{{ $karya->id }}"
                            class="group bg-white rounded-2xl border border-riak-honey/5 p-4 transition-all duration-500 hover:shadow-xl hover:border-riak-honey/20">

                            {{-- Frame Gambar Unggahan User --}}
                            <div
                                class="relative aspect-[4/5] rounded-xl overflow-hidden bg-riak-cream/30 mb-6 shadow-sm">
                                <img src="{{ asset('storage/' . $karya->image_url) }}"
                                    alt="Karya {{ $karya->user->name ?? 'User' }}"
                                    class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                            </div>

                            {{-- Keterangan Info Nama Pembuat Karya --}}
                            <div class="space-y-3 px-1">
                                <span class="text-[9px] text-riak-honey font-bold uppercase tracking-widest block">
                                    @id
                                        Oleh
                                    @endid @en Crafted By @enden
                                </span>
                                <h3
                                    class="text-xl font-serif text-riak-army italic tracking-wide group-hover:text-riak-honey transition-colors truncate">
                                    {{ $karya->user->name ?? 'Anonymous Creator' }}
                                </h3>
                                <div class="w-8 h-[1px] bg-riak-honey/60 transition-all group-hover:w-16 duration-500">
                                </div>
                                <p class="text-riak-khaki text-[11px] font-mono opacity-60">
                                    Approved: {{ $karya->updated_at->translatedFormat('d M Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @empty
            {{-- State Kosong Jika Belum Ada Karya Berstatus Approved --}}
            <section class="w-full">
                <div
                    class="col-span-full py-32 flex flex-col items-center justify-center border-2 border-dashed border-riak-honey/20 rounded-[3rem] bg-riak-honey/5 text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-sm mb-8">
                        <svg class="w-10 h-10 text-riak-honey/30" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-serif text-riak-army italic mb-3">
                        @id
                            Eksibisi belum tersedia
                        @endid
                        @en Exhibition currently unavailable @enden
                    </h4>
                    <p class="text-riak-khaki text-[11px] uppercase tracking-[0.3em] font-bold opacity-60">
                        @id
                            Kami sedang mengkurasi karya-karya terbaik perakit kit kami
                        @endid
                        @en We are currently curating the finest creations from our builders @enden
                    </p>
                </div>
            </section>
        @endforelse
    </div>

    {{-- FOOTER / CALL TO ACTION (CTA) AREA --}}
    <section class="bg-riak-cream py-24 text-center border-t border-riak-honey/10">
        <h4 class="text-riak-honey text-[10px] font-black uppercase tracking-[0.4em] mb-8">
            @id
                Siap Memulai Petualangan Kreatifmu?
            @endid
            @en Ready to Start Your Creative Journey? @enden
        </h4>
        <a href="/" wire:navigate
            class="group relative inline-flex items-center gap-6 text-riak-army font-serif text-2xl italic tracking-widest transition-all">
            @id
                Jelajahi Store
            @endid @en Explore Store @enden
            <span class="w-12 h-[1px] bg-riak-persimmon transition-all group-hover:w-20"></span>
        </a>
    </section>
</div>

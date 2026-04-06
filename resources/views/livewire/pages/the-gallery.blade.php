<div class="bg-white min-h-screen selection:bg-riak-honey/30">
    <header class="pt-40 pb-20 px-6 text-center">
        <div class="max-w-4xl mx-auto">
            <h2
                class="text-riak-honey text-[11px] font-bold uppercase tracking-[0.6em] mb-6 animate-[fadeIn_1s_ease-out]">
                @id
                    Rangkaian Pilihan Riak
                @endid @en Sequence of Riak @enden
            </h2>
            <h1 class="text-5xl md:text-7xl font-serif text-riak-army leading-tight mb-8">
                @id
                    Abadikan <span class="italic font-light text-riak-persimmon">Kilau</span>
                @endid
                @en Capture the <span class="italic font-light text-riak-persimmon">Sparkle</span> @enden
            </h1>
            <p class="text-riak-khaki font-light text-sm md:text-base max-w-2xl mx-auto leading-[2]">
                @id
                    Menjelajahi keanggunan sulam emas Air Guci melalui siluet modern. Setiap detail adalah penghormatan
                    terhadap ketelitian tangan para maestro Banjar yang melampaui waktu.
                @endid
                @en Discover the elegance of Air Guci’s gold embroidery through modern silhouettes. Every detail pays
                homage to the timeless craftsmanship of the Banjar masters. @enden
            </p>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-6 py-10">
        <div class="mb-16 border-b border-riak-honey/20 pb-6">
            <h2 class="font-serif text-3xl italic text-riak-army">Riak Ready to Wear</h2>
        </div>

        <div class="flex overflow-x-auto pb-8 gap-6 snap-x no-scrollbar">
            @forelse ($products as $product)
                <div class="group flex-none w-[280px] md:w-1/4 snap-start">
                    <div class="relative aspect-[3/4] bg-riak-cream rounded-2xl overflow-hidden mb-5 shadow-sm">
                        <div
                            class="absolute top-4 left-4 z-10 bg-riak-persimmon text-white text-[8px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                            {{ $product->tag }}
                        </div>
                        <img src="{{ asset('storage/' . $product->image) }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            alt="{{ $product->name }}">
                    </div>
                    <h3 class="text-[12px] font-bold uppercase tracking-widest text-riak-army mb-1">{{ $product->name }}
                    </h3>
                    <p class="text-sm text-riak-honey font-serif italic mb-4">IDR
                        {{ number_format($product->price, 0, ',', '.') }}</p>
                    <a href="{{ $product->link_shopee }}" target="_blank"
                        class="w-full bg-riak-army text-riak-cream py-4 text-center rounded-xl text-[9px] font-bold uppercase tracking-[0.2em] transition-all hover:bg-riak-honey">
                        @id
                            Beli Sekarang
                        @endid @en Buy Now @enden
                    </a>
                </div>
            @empty
                @foreach (range(1, 4) as $i)
                    <div class="flex-none w-[280px] md:w-1/4 opacity-40">
                        <div
                            class="aspect-[3/4] border-2 border-dashed border-riak-honey/20 rounded-2xl mb-5 flex items-center justify-center">
                            <svg class="w-8 h-8 text-riak-honey/20" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="h-3 w-3/4 bg-riak-honey/10 rounded mb-2"></div>
                        <div class="h-3 w-1/2 bg-riak-honey/5 rounded"></div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </section>

    <section class="bg-riak-army py-24 my-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-16">
                <span class="text-riak-honey text-[10px] font-bold uppercase tracking-[0.4em]">Creative Kit</span>
                <h2
                    class="text-4xl font-serif text-riak-cream mt-4 leading-tight italic underline decoration-riak-persimmon underline-offset-8">
                    Riak DIY Kit
                </h2>
            </div>

            <div class="flex overflow-x-auto pb-8 gap-8 no-scrollbar snap-x">
                @forelse ($kits as $kit)
                    <div
                        class="flex-none w-[320px] md:w-[550px] snap-start bg-white/5 border border-white/10 rounded-[2.5rem] overflow-hidden group flex flex-col sm:flex-row items-center">
                        <div class="w-full sm:w-1/2 aspect-square overflow-hidden">
                            <img src="{{ asset('storage/' . $kit->image) }}"
                                class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                alt="{{ $kit->name }}">
                        </div>
                        <div class="p-8 sm:w-1/2 flex flex-col justify-between h-full">
                            <div>
                                <span
                                    class="text-[9px] font-bold text-riak-honey border border-riak-honey/40 px-3 py-1 rounded-full uppercase mb-4 inline-block tracking-widest">
                                    {{ $kit->level }}
                                </span>
                                <h3 class="text-2xl text-riak-cream font-serif italic mb-2">{{ $kit->name }}</h3>
                                <p class="text-riak-cream/50 text-xs font-light leading-relaxed mb-6">
                                    {{ $kit->description }}</p>
                                <h4 class="text-xl text-riak-honey font-serif mb-6">IDR
                                    {{ number_format($kit->price, 0, ',', '.') }}</h4>
                            </div>
                            <a href="{{ $kit->link_shopee }}" target="_blank"
                                class="w-full border border-riak-cream/30 text-center text-riak-cream py-4 rounded-2xl text-[10px] font-bold uppercase tracking-widest hover:bg-riak-cream hover:text-riak-army transition-all">
                                @id
                                    Beli Sekarang
                                @endid @en Buy Now @enden
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="flex-none w-full py-20 border border-white/10 rounded-[2.5rem] bg-white/5 text-center">
                        <p class="text-riak-cream/40 font-serif italic">
                            @id
                                Koleksi kit kreatif sedang dipersiapkan.
                            @endid
                            @en Creative kits collection is being prepared. @enden
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-24">
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-5xl font-serif text-riak-army italic mb-4">Riak Experience</h2>
            <div class="w-24 h-[1px] bg-riak-honey mx-auto mb-6"></div>
            <p class="text-riak-persimmon text-[10px] font-bold uppercase tracking-[0.5em]">Curated Cultural Journeys
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            @forelse ($trips as $trip)
                <div class="relative group h-[550px] overflow-hidden rounded-[3rem] shadow-2xl cursor-pointer">
                    <img src="{{ asset('storage/' . $trip->image) }}"
                        class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-110"
                        alt="{{ $trip->title }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-riak-army via-riak-army/40 to-transparent"></div>
                    <div class="absolute inset-0 p-10 flex flex-col justify-end">
                        <div class="flex gap-3 mb-6">
                            <span
                                class="bg-riak-persimmon text-white text-[9px] font-bold px-4 py-2 rounded-full uppercase tracking-widest shadow-lg">
                                {{ $trip->duration }}
                            </span>
                            <span
                                class="bg-white/10 backdrop-blur-md border border-white/20 text-riak-cream text-[9px] font-bold px-4 py-2 rounded-full uppercase tracking-widest">
                                @id
                                    Mulai dari
                                @endid @en Starts from @enden {{ $trip->price_display }}
                            </span>
                        </div>
                        <h3
                            class="text-4xl md:text-5xl font-serif text-riak-cream mb-6 italic leading-tight transition-transform duration-500 group-hover:-translate-y-2">
                            {{ $trip->title }}
                        </h3>
                        <p
                            class="max-h-0 overflow-hidden opacity-0 group-hover:max-h-40 group-hover:opacity-100 group-hover:mb-8 transition-all duration-700 text-riak-cream/80 text-sm font-light leading-relaxed max-w-sm">
                            {{ $trip->description }}
                        </p>
                        <a href="{{ route('trip.show', $trip->slug) }}" wire:navigate
                            class="w-full bg-riak-cream text-riak-army py-5 rounded-2xl text-[10px] text-center font-black uppercase tracking-[0.3em] hover:bg-riak-honey hover:text-white transition-all duration-500 shadow-xl">
                            @id
                                Pesan Pengalaman
                            @endid @en Book Your Experience @enden
                        </a>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-32 flex flex-col items-center justify-center border-2 border-dashed border-riak-honey/10 rounded-[3rem] bg-riak-cream">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-6">
                        <svg class="w-6 h-6 text-riak-honey/40" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="font-serif italic text-riak-army text-xl">
                        @id
                            Belum ada jadwal perjalanan tersedia.
                        @endid
                        @en No travel schedules available yet. @enden
                    </p>
                </div>
            @endforelse
        </div>
    </section>
</div>

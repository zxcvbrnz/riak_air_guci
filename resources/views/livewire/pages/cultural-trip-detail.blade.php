<div class="bg-white min-h-screen selection:bg-[#BC6C25]/20">
    @php $locale = app()->getLocale(); @endphp

    <section class="relative h-[75vh] flex items-center justify-center overflow-hidden bg-[#283618]">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/' . $trip->image) }}" class="w-full h-full object-cover opacity-60 scale-105"
                alt="{{ $trip->{'title_' . $locale} }}">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#283618]/80"></div>
        </div>

        <div class="relative z-10 text-center px-6 max-w-5xl animate-[fadeIn_1.2s_ease-out]">
            <span class="text-[#DDA15E] text-[10px] font-bold uppercase tracking-[0.6em] mb-6 block">
                The Cultural Odyssey
            </span>
            <h1 class="text-5xl md:text-8xl font-serif text-white italic leading-tight">
                {{ $trip->{'title_' . $locale} }}
            </h1>
        </div>
    </section>

    <div class="bg-[#FEFAE0] py-10 border-b border-[#DDA15E]/10">
        <div class="max-w-7xl mx-auto px-6 flex flex-wrap justify-center gap-12 md:gap-32 text-[#283618]">
            <div class="text-center">
                <span class="block text-[9px] uppercase tracking-[0.3em] text-[#BC6C25] font-bold mb-2">Duration</span>
                <span class="font-serif italic text-xl md:text-2xl">{{ $trip->duration }}</span>
            </div>
            <div class="text-center">
                <span
                    class="block text-[9px] uppercase tracking-[0.3em] text-[#BC6C25] font-bold mb-2">Investment</span>
                <span class="font-serif italic text-xl md:text-2xl">IDR {{ $trip->price_display }}</span>
            </div>
        </div>
    </div>

    <section class="max-w-7xl mx-auto px-6 py-24 md:py-32">
        <div class="grid lg:grid-cols-12 gap-20">

            <div class="lg:col-span-7">
                <div class="mb-24">
                    <h2 class="text-3xl font-serif text-[#283618] italic mb-8">
                        @id
                            Esensi Perjalanan
                        @endid @en The Essence @enden
                    </h2>
                    <p class="text-[#606C38] leading-[2.2] font-light text-lg md:text-xl italic">
                        {{ $trip->{'description_' . $locale} }}
                    </p>
                </div>

                <div>
                    <h2 class="text-3xl font-serif text-[#283618] italic mb-16">
                        @id
                            Rencana Perjalanan
                        @endid @en Itinerary @enden
                    </h2>
                    <div
                        class="space-y-16 relative before:absolute before:left-[19px] before:top-2 before:bottom-2 before:w-[1px] before:bg-[#BC6C25]/20">
                        @foreach ($trip->rutes as $index => $rute)
                            <div class="relative pl-16 group">
                                <div
                                    class="absolute left-0 top-1 w-10 h-10 rounded-full bg-white border border-[#BC6C25] flex items-center justify-center z-10 transition-transform group-hover:scale-110">
                                    <span class="text-[10px] font-bold text-[#BC6C25]">{{ $index + 1 }}</span>
                                </div>

                                <h3 class="text-2xl font-serif text-[#283618] mb-4">{{ $rute->{'title_' . $locale} }}
                                </h3>
                                <p class="text-[#283618]/70 leading-relaxed font-light">
                                    {{ $rute->{'description_' . $locale} }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div
                    class="sticky top-32 bg-white border border-[#DDA15E]/20 p-8 md:p-12 rounded-[3rem] shadow-2xl shadow-[#283618]/5">
                    <h3 class="text-2xl font-serif text-[#283618] italic mb-8">
                        @id
                            Jadwal Keberangkatan
                        @endid @en Available Batches @enden
                    </h3>

                    <div class="space-y-4 mb-12">
                        @forelse($trip->batches as $batch)
                            <div
                                class="flex items-center justify-between p-6 rounded-2xl border border-[#FEFAE0] bg-[#FEFAE0]/30 hover:border-[#BC6C25]/30 transition-all">
                                <div>
                                    <span class="block text-sm font-bold text-[#283618]">
                                        {{ \Carbon\Carbon::parse($batch->departure_date)->translatedFormat('d F Y') }}
                                    </span>
                                    <span class="text-[10px] uppercase text-[#BC6C25] tracking-widest font-medium">
                                        {{ $batch->available_seats }} @id
                                            Kursi Tersedia
                                        @endid @en Seats Available @enden
                                    </span>
                                </div>
                                <div
                                    class="w-2 h-2 rounded-full {{ $batch->available_seats > 0 ? 'bg-green-500' : 'bg-red-400' }}">
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 border border-dashed border-[#DDA15E]/30 rounded-2xl">
                                <p class="text-[#283618]/40 italic text-sm">
                                    @id
                                        Jadwal akan segera hadir
                                    @endid @en Coming soon @enden
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <div class="space-y-4">
                        <a href="https://wa.me/6285249558488" target="_blank"
                            class="block w-full bg-[#283618] text-[#FEFAE0] text-center py-5 rounded-2xl text-[11px] font-bold uppercase tracking-[0.2em] hover:bg-[#BC6C25] transition-all duration-500 shadow-xl shadow-[#283618]/10">
                            @id
                                Reservasi Sekarang
                            @endid @en Book Your Journey @enden
                        </a>
                        <p class="text-[9px] text-center text-[#283618]/40 uppercase tracking-[0.2em]">
                            * @id
                                Termasuk akomodasi & workshop
                            @endid @en Includes accommodation & workshop @enden
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="max-w-7xl mx-auto px-6 pb-20 text-center">
        <a href="{{ route('gallery') }}" wire:navigate
            class="inline-flex items-center gap-4 text-[10px] font-bold uppercase tracking-widest text-[#BC6C25] hover:opacity-70 transition-opacity">
            <span class="w-8 h-[1px] bg-[#BC6C25]"></span>
            @id
                Kembali ke Koleksi
            @endid @en Back to Gallery @enden
        </a>
    </div>
</div>

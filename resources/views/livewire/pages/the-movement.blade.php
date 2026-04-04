<div class="bg-white min-h-screen selection:bg-riak-honey/30">
    <header class="pt-48 pb-20 px-6 text-center">
        <div class="max-w-4xl mx-auto">
            <h2
                class="text-riak-honey text-[11px] font-bold uppercase tracking-[0.6em] mb-6 animate-[fadeIn_1s_ease-out]">
                Social Impact
            </h2>
            <h1 class="text-5xl md:text-7xl font-serif text-riak-army leading-tight mb-8">
                @id
                    Arus <span class="italic font-light text-riak-persimmon">Gerak</span>
                @endid
                @en Riak <span class="italic font-light text-riak-persimmon">Current</span> @enden
            </h1>
            <p class="text-riak-khaki font-light text-sm md:text-base max-w-2xl mx-auto leading-[2]">
                @id
                    Menanamkan rasa bangga akan identitas Banua sejak dini. Kami bergerak dari sekolah ke sekolah,
                    menghubungkan tangan-tangan muda dengan benang emas warisan maestro.
                @endid
                @en Instilling pride in Banua identity from an early age. We move from school to school, connecting
                young hands with the golden threads of master heritage. @enden
            </p>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-6 py-20 border-t border-riak-honey/10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-xl">
                <span class="text-riak-honey text-[10px] font-bold uppercase tracking-widest">
                    @id
                        Rangkai Ilmu
                    @endid @en Education Series @enden
                </span>
                <h2 class="text-4xl font-serif text-riak-army mt-4 italic">Riak Goes to School</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($schools as $school)
                <div
                    class="group relative bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-riak-cream">
                    <div class="relative aspect-[4/3] overflow-hidden bg-riak-army">
                        @if ($school->type == 'video')
                            <div class="absolute inset-0 flex items-center justify-center z-10">
                                <div
                                    class="w-12 h-12 bg-white/30 backdrop-blur-md rounded-full flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white fill-current" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                        @endif
                        <img src="{{ asset('storage/' . $school->media_path) }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 {{ $school->type == 'video' ? 'opacity-60' : '' }}"
                            alt="{{ $school->title }}">
                        <div
                            class="absolute top-4 left-4 bg-riak-persimmon text-white text-[8px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">
                            {{ $school->label }}
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="font-serif text-xl text-riak-army mb-3 italic">{{ $school->title }}</h3>
                        <p class="text-riak-khaki text-xs font-light leading-relaxed mb-6 line-clamp-2">
                            {{ $school->description }}</p>
                        <a href="{{ $school->type == 'video' ? $school->video_url : '#' }}"
                            class="inline-flex items-center text-[10px] font-bold uppercase tracking-widest text-riak-honey group/link">
                            @id
                                Lihat Dokumentasi
                            @endid @en View Documentation @enden
                            <svg class="w-3 h-3 ml-2 transform group-hover/link:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                @foreach (range(1, 3) as $i)
                    <div
                        class="bg-riak-cream/30 rounded-[2rem] p-8 border border-dashed border-riak-honey/20 animate-pulse">
                        <div class="aspect-[4/3] bg-riak-honey/5 rounded-xl mb-6"></div>
                        <div class="h-4 w-3/4 bg-riak-honey/10 rounded mb-4"></div>
                        <div class="h-3 w-full bg-riak-honey/5 rounded"></div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </section>

    <section class="bg-riak-army py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="text-riak-honey text-[10px] font-bold uppercase tracking-[0.5em]">
                    @id
                        Marwah Tradisi & Riak Cipta
                    @endid @en The Maestro & Innovation @enden
                </span>
                <h2 class="text-3xl font-serif text-riak-cream mt-2 italic">
                    @id
                        Sosok di Balik Riak Air Guci
                    @endid @en Riak Air Guci Figure @enden
                </h2>
            </div>
            <p class="text-riak-cream/50 text-[10px] uppercase tracking-widest border-l border-riak-persimmon/30 pl-4">
                @id
                    Dedikasi & Warisan
                @endid @en Dedication & Legacy @enden
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($artisans as $artisan)
                    <div
                        class="group relative bg-white/5 rounded-[2.5rem] p-4 border border-white/5 transition-all duration-500 hover:border-riak-persimmon/30 shadow-xl">
                        <div class="relative aspect-square rounded-[2rem] overflow-hidden mb-6">
                            <img src="{{ asset('storage/' . $artisan->photo) }}"
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 group-hover:scale-110"
                                alt="{{ $artisan->name }}">
                            <div
                                class="absolute inset-0 bg-riak-army/80 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center p-8 text-center">
                                <p class="text-riak-cream text-xs font-light italic leading-relaxed">
                                    "{{ $artisan->quote }}"</p>
                            </div>
                        </div>
                        <div class="px-4 pb-4 text-center">
                            <h3 class="text-xl font-serif text-riak-cream italic mb-1">{{ $artisan->name }}</h3>
                            <p class="text-riak-persimmon text-[9px] font-bold uppercase tracking-widest mb-6">
                                {{ $artisan->role }}</p>
                            <a href="#"
                                class="inline-block w-full py-3 rounded-xl border border-white/10 text-riak-cream text-[9px] font-bold uppercase tracking-widest hover:bg-riak-cream hover:text-riak-army transition-all duration-300">
                                @id
                                    Detail Profil
                                @endid @en Profile Detail @enden
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center border border-white/10 rounded-[2.5rem]">
                        <p class="text-riak-cream/30 italic font-serif">
                            @id
                                Belum ada profil maestro yang tersedia.
                            @endid @en No artisan profiles available yet. @enden
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-32">
        <div
            class="relative bg-riak-persimmon/5 rounded-[3.5rem] overflow-hidden p-12 md:p-24 border border-riak-persimmon/10">
            <div class="relative z-10 grid md:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="text-riak-honey text-[10px] font-bold uppercase tracking-[0.5em] mb-6 block">
                        @id
                            Jalin Kolaborasi
                        @endid @en Become a Partner @enden
                    </span>
                    <h2 class="text-4xl md:text-5xl font-serif text-riak-army leading-tight italic mb-8">
                        @id
                            Mari Rangkai Asa Bersama.
                        @endid @en Let’s Weave Our Hopes Together. @enden
                    </h2>
                    <p class="text-riak-khaki font-light text-sm md:text-base leading-relaxed mb-10">
                        @id
                            Saatnya sekolah kalian menjadi bagian dari gerakan pelestarian budaya! Mari berkolaborasi
                            bersama kami dalam workshop, pameran, dan program edukasi kreatif berbasis sulam Air Guci.
                        @endid
                        @en Join the cultural preservation movement! Let’s collaborate on workshops, exhibitions, and
                        creative educational programs centered around Air Guci embroidery. @enden
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="https://wa.me/6285249558488" target="_blank"
                            class="bg-riak-army text-riak-cream px-10 py-5 rounded-2xl text-[10px] font-bold uppercase tracking-widest hover:bg-riak-honey transition-all shadow-xl shadow-riak-army/10">
                            @id
                                Hubungi Kami Via WhatsApp
                            @endid @en Contact Us via WhatsApp @enden
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    @php
                        $ctas = [
                            [
                                'icon' =>
                                    'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                                'title_id' => 'Edukasi Budaya',
                                'title_en' => 'Cultural Education',
                                'desc_id' => 'Kurikulum singkat yang adaptif untuk segala usia.',
                                'desc_en' => 'Concise, adaptable curriculum for all ages',
                            ],
                            [
                                'icon' =>
                                    'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9-3-9m-9 9a9 9 0 019-9',
                                'title_id' => 'Jangkauan Global',
                                'title_en' => 'Global Reach',
                                'desc_id' => 'Membawa Karya Lokal ke Standar Estetika Internasional',
                                'desc_en' => 'Bringing Local Art to International Aesthetic Standards',
                            ],
                        ];
                    @endphp
                    @foreach ($ctas as $cta)
                        <div
                            class="bg-white/60 backdrop-blur-md p-8 rounded-3xl border border-white flex gap-6 items-start">
                            <div
                                class="w-12 h-12 bg-riak-honey/10 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-riak-honey" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="{{ $cta['icon'] }}"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-serif text-lg text-riak-army italic">
                                    {{ app()->getLocale() == 'en' ? $cta['title_en'] : $cta['title_id'] }}
                                </h4>
                                <p class="text-riak-khaki text-[11px] font-light leading-relaxed mt-1">
                                    {{ app()->getLocale() == 'en' ? $cta['desc_en'] : $cta['desc_id'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>

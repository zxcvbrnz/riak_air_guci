<div class="bg-white min-h-screen selection:bg-[#BC6C25]/20">
    <header class="pt-48 pb-20 px-6 text-center">
        <div class="max-w-4xl mx-auto">
            <h2
                class="text-[#BC6C25] text-[11px] font-bold uppercase tracking-[0.6em] mb-6 animate-[fadeIn_1s_ease-out]">
                Social Impact
            </h2>
            <h1 class="text-5xl md:text-7xl font-serif text-[#283618] leading-tight mb-8">
                The <span class="italic font-light text-[#DDA15E]">Movement</span>
            </h1>
            <p class="text-[#606C38] font-light text-sm md:text-base max-w-2xl mx-auto leading-[2]">
                Menanamkan rasa bangga akan identitas Banua sejak dini. Kami bergerak dari sekolah ke sekolah,
                menghubungkan tangan-tangan muda dengan benang emas warisan maestro.
            </p>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-6 py-20 border-t border-[#DDA15E]/10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-xl">
                <span class="text-[#BC6C25] text-[10px] font-bold uppercase tracking-widest">Education Series</span>
                <h2 class="text-4xl font-serif text-[#283618] mt-4 italic">Riak Goes to School</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($schools as $school)
                <div
                    class="group relative bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative aspect-[4/3] overflow-hidden bg-[#283618]">
                        @if ($school->type == 'video')
                            <div class="absolute inset-0 flex items-center justify-center z-10">
                                <div
                                    class="w-12 h-12 bg-[#FEFAE0]/30 backdrop-blur-md rounded-full flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform">
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
                            class="absolute top-4 left-4 bg-[#BC6C25] text-[#FEFAE0] text-[8px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">
                            {{ $school->label }}
                        </div>
                    </div>

                    <div class="p-8">
                        <h3 class="font-serif text-xl text-[#283618] mb-3 italic">{{ $school->title }}</h3>
                        <p class="text-[#606C38] text-xs font-light leading-relaxed mb-6 line-clamp-2">
                            {{ $school->description }}
                        </p>
                        <a href=""
                            class="inline-flex items-center text-[10px] font-bold uppercase tracking-widest text-[#BC6C25] group/link">
                            Lihat Dokumentasi
                            <svg class="w-3 h-3 ml-2 transform group-hover/link:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-[#283618] py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="text-[#DDA15E] text-[10px] font-bold uppercase tracking-[0.5em]">The Maestro &
                    Innovation</span>
                <h2 class="text-3xl font-serif text-[#FEFAE0] mt-2 italic">Sosok di Balik Pusaka Banua</h2>
            </div>
            <p class="text-[#FEFAE0]/50 text-[10px] uppercase tracking-widest border-l border-[#DDA15E]/30 pl-4">
                Dedikasi & Warisan
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($artisans as $artisan)
                    <div
                        class="group relative bg-[#2c3d1b] rounded-[2.5rem] p-4 border border-[#FEFAE0]/5 transition-all duration-500 hover:border-[#DDA15E]/30 shadow-xl">
                        <div class="relative aspect-square rounded-[2rem] overflow-hidden mb-6">
                            <img src="{{ asset('storage/' . $artisan->photo) }}"
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 group-hover:scale-110"
                                alt="{{ $artisan->name }}">

                            <div
                                class="absolute inset-0 bg-[#283618]/80 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center p-8 text-center">
                                <p class="text-[#FEFAE0] text-xs font-light italic leading-relaxed">
                                    "{{ $artisan->quote }}"
                                </p>
                            </div>
                        </div>

                        <div class="px-4 pb-4 text-center">
                            <h3 class="text-xl font-serif text-[#FEFAE0] italic mb-1">{{ $artisan->name }}</h3>
                            <p class="text-[#DDA15E] text-[9px] font-bold uppercase tracking-widest mb-6">
                                {{ $artisan->role }}
                            </p>

                            <a href=""
                                class="inline-block w-full py-3 rounded-xl border border-[#FEFAE0]/10 text-[#FEFAE0] text-[9px] font-bold uppercase tracking-widest hover:bg-[#FEFAE0] hover:text-[#283618] transition-all duration-300">
                                Detail Profil
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="max-w-7xl mx-auto px-6 py-32">
        <div class="relative bg-[#DDA15E]/10 rounded-[3.5rem] overflow-hidden p-12 md:p-24 border border-[#DDA15E]/20">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#BC6C25]/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-[#283618]/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 grid md:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="text-[#BC6C25] text-[10px] font-bold uppercase tracking-[0.5em] mb-6 block">Become a
                        Partner</span>
                    <h2 class="text-4xl md:text-5xl font-serif text-[#283618] leading-tight italic mb-8">
                        Mari Menenun <br> Masa Depan Bersama.
                    </h2>
                    <p class="text-[#606C38] font-light text-sm md:text-base leading-relaxed mb-10 opacity-80">
                        Apakah sekolah atau komunitas Anda ingin menjadi bagian dari pelestarian budaya sulam Air Guci?
                        Kami membuka pintu kolaborasi untuk workshop, pameran, maupun program edukasi kreatif lainnya.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="https://wa.me/62xxxxxxxxxx" target="_blank"
                            class="bg-[#283618] text-[#FEFAE0] px-10 py-5 rounded-2xl text-[10px] font-bold uppercase tracking-widest hover:bg-[#BC6C25] transition-all shadow-xl shadow-[#283618]/10">
                            Hubungi Kami via WhatsApp
                        </a>
                        <a href="mailto:hello@pusakabanua.id"
                            class="border border-[#283618]/20 text-[#283618] px-10 py-5 rounded-2xl text-[10px] font-bold uppercase tracking-widest hover:bg-[#283618] hover:text-[#FEFAE0] transition-all">
                            Kirim Email
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    @foreach ([['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Edukasi Budaya', 'desc' => 'Kurikulum singkat yang adaptif untuk segala usia.'], ['icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9-3-9m-9 9a9 9 0 019-9', 'title' => 'Jangkauan Global', 'desc' => 'Membawa karya lokal ke standar estetika internasional.']] as $cta)
                        <div
                            class="bg-white/40 backdrop-blur-md p-8 rounded-3xl border border-white/50 flex gap-6 items-start">
                            <div class="w-12 h-12 bg-[#BC6C25]/20 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-[#BC6C25]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="{{ $cta['icon'] }}"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-serif text-lg text-[#283618] italic">{{ $cta['title'] }}</h4>
                                <p class="text-[#606C38] text-[11px] font-light leading-relaxed mt-1">
                                    {{ $cta['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>

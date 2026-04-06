<div class="bg-white min-h-screen selection:bg-riak-honey/20">
    @php $locale = app()->getLocale(); @endphp

    <section class="relative h-[85vh] flex items-end overflow-hidden bg-riak-army">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/' . $artisan->photo) }}" class="w-full h-full object-cover opacity-40 scale-105"
                alt="{{ $artisan->name }}">
            <div class="absolute inset-0 bg-gradient-to-t from-riak-army via-riak-army/40 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 pb-24 w-full">
            <div class="max-w-4xl animate-[fadeInUp_1s_ease-out]">
                <span class="text-riak-persimmon text-[10px] font-bold uppercase tracking-[0.5em] mb-5 block">
                    {{ $artisan->{'role_' . $locale} }}
                </span>
                <h1 class="text-6xl md:text-8xl font-serif text-riak-cream leading-none mb-8 italic">
                    {{ $artisan->name }}
                </h1>
                <div class="h-[2px] w-24 bg-riak-honey"></div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-24 md:py-32">
        <div class="grid lg:grid-cols-12 gap-16 md:gap-24">

            <div class="lg:col-span-5">
                <div class="lg:sticky lg:top-40 space-y-12">
                    <div class="relative">
                        <span class="text-8xl font-serif text-riak-persimmon/10 absolute -top-12 -left-8">“</span>
                        <h2 class="text-3xl md:text-4xl font-serif italic text-riak-army leading-tight relative z-10">
                            {{ $artisan->{'quote_' . $locale} }}
                        </h2>
                        <div class="w-12 h-[1px] bg-riak-honey/30 mt-8"></div>
                    </div>

                    <div class="rounded-[2rem] overflow-hidden shadow-lg border border-riak-honey/10">
                        <img src="{{ asset('storage/' . $artisan->photo) }}" class="w-full h-auto object-cover"
                            alt="{{ $artisan->name }}">
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="prose prose-stone max-w-none">
                    <p class="text-xl md:text-2xl text-riak-army/80 font-light leading-[1.8] italic mb-12">
                        {{ $artisan->{'description_' . $locale} }}
                    </p>

                    <div class="space-y-10 text-riak-army/70 leading-[2.2] font-light text-base md:text-lg">
                        <p>
                            @id
                                Setiap karya yang lahir dari tangan beliau adalah hasil dari ketekunan luar biasa.
                                Penggunaan benang emas asli dan teknik tusukan tradisional yang beliau kuasai
                                menjadikan setiap helai kain memiliki jiwa dan cerita tersendiri.
                            @endid
                            @en
                            Every work born from her hands is the result of extraordinary perseverance.
                            The use of authentic gold thread and the traditional stitching techniques she
                            masters give every piece of fabric its own soul and story.
                            @enden
                        </p>
                    </div>

                    <div class="mt-24 pt-10 border-t border-riak-persimmon/10">
                        <a href="{{ route('movement') }}" wire:navigate class="inline-flex items-center gap-5 group">
                            <span
                                class="w-14 h-14 rounded-full border border-riak-honey flex items-center justify-center group-hover:bg-riak-honey transition-all duration-500">
                                <svg class="w-5 h-5 text-riak-honey group-hover:text-white transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <div class="flex flex-col">
                                <span class="text-[9px] font-bold uppercase tracking-[0.3em] text-riak-honey/60">
                                    @id
                                        Jelajahi
                                    @endid @en Explore @enden
                                </span>
                                <span class="text-xs font-bold uppercase tracking-[0.2em] text-riak-army">
                                    @id
                                        Sosok Lainnya
                                    @endid @en Other Figure @enden
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

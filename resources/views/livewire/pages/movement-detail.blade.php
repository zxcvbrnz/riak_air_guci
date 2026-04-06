<div class="bg-white min-h-screen">
    @php $locale = app()->getLocale(); @endphp

    <article class="max-w-5xl mx-auto px-6 pt-40 pb-20">
        <header class="mb-12">
            <nav class="mb-8">
                <a href="{{ route('movement') }}" wire:navigate
                    class="text-[#BC6C25] text-[10px] font-bold uppercase tracking-[0.3em]">
                    ← @id
                        Kembali ke Gerakan
                    @endid @en Back to Movement @enden
                </a>
            </nav>

            <h1 class="text-4xl md:text-6xl font-serif text-[#283618] italic leading-tight">
                {{ $school->{'title_' . $locale} }}
            </h1>
        </header>

        <div class="grid lg:grid-cols-12 gap-16">
            <div class="lg:col-span-8">
                <div class="rounded-[2.5rem] overflow-hidden bg-[#283618] mb-10 shadow-xl border border-[#DDA15E]/10">
                    @if ($school->type == 'video' && $school->video_url)
                        @php
                            // Logika konversi berbagai format link YouTube ke format Embed
                            $videoUrl = $school->video_url;
                            $embedUrl = $videoUrl;

                            if (strpos($videoUrl, 'youtube.com/watch?v=') !== false) {
                                $embedUrl = str_replace('watch?v=', 'embed/', $videoUrl);
                            } elseif (strpos($videoUrl, 'youtu.be/') !== false) {
                                $embedUrl = str_replace('youtu.be/', 'youtube.com/embed/', $videoUrl);
                            }

                            // Menghapus parameter tambahan jika ada (seperti &t= atau &feature) agar embed bersih
                            $embedUrl = explode('&', $embedUrl)[0];
                        @endphp

                        <div class="aspect-video w-full">
                            <iframe class="w-full h-full" src="{{ $embedUrl }}?rel=0&modestbranding=1"
                                title="{{ $school->{'title_' . $locale} }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>
                    @else
                        <img src="{{ asset('storage/' . $school->media_path) }}"
                            class="w-full aspect-video object-cover" alt="{{ $school->{'title_' . $locale} }}">
                    @endif
                </div>

                <div class="prose prose-stone max-w-none">
                    <p class="text-xl text-[#606C38] leading-relaxed font-light italic whitespace-pre-line">
                        {{ $school->{'description_' . $locale} }}
                    </p>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="bg-[#FEFAE0]/50 border border-[#DDA15E]/10 p-10 rounded-[2.5rem] sticky top-32">
                    <span class="text-[#BC6C25] text-[9px] font-bold uppercase tracking-[0.4em] block mb-4">
                        {{ $school->{'label_' . $locale} }}
                    </span>
                    <hr class="border-[#DDA15E]/10 mb-6">

                    <p class="text-xs text-[#606C38] leading-loose">
                        @id
                            Dokumentasi ini adalah bagian dari komitmen kami dalam melestarikan Sulam Air Guci di
                            sekolah-sekolah se-Kalimantan Selatan.
                        @endid
                        @en
                        This documentation is part of our commitment to preserving Air Guci Embroidery in schools
                        throughout South Kalimantan.
                        @enden
                    </p>
                </div>
            </div>
        </div>
    </article>
</div>

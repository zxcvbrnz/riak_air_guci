<div class="bg-white min-h-screen selection:bg-[#BC6C25]/20">

    <header class="pt-40 pb-20 px-6 text-center">
        <div class="max-w-4xl mx-auto">
            <h2
                class="text-[#BC6C25] text-[11px] font-bold uppercase tracking-[0.6em] mb-6 animate-[fadeIn_1s_ease-out]">
                The Curated Collection
            </h2>
            <h1 class="text-5xl md:text-7xl font-serif text-[#283618] leading-tight mb-8">
                Manifestasi <span class="italic font-light text-[#DDA15E]">Tradisi</span>
            </h1>
            <p class="text-[#606C38] font-light text-sm md:text-base max-w-2xl mx-auto leading-[2]">
                Menjelajahi keanggunan sulam emas Air Guci melalui siluet modern.
                Setiap detail adalah penghormatan terhadap ketelitian tangan para maestro Banjar yang melampaui waktu.
            </p>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-6 py-10">
        <div class="mb-16 border-b border-[#DDA15E]/20 pb-6">
            <h2 class="font-serif text-3xl italic text-[#283618]">Ready to Wear Series</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-12">
            @foreach ([['name' => 'Kebaya Riak Gold', 'price' => '1.250.000', 'tag' => 'Upcycled', 'img' => 'ready-1.jpg'], ['name' => 'Outer Air Guci Noir', 'price' => '890.000', 'tag' => 'Limited', 'img' => 'ready-2.jpg'], ['name' => 'Pouch Sulam Heritage', 'price' => '350.000', 'tag' => 'Best Seller', 'img' => 'ready-3.jpg'], ['name' => 'Scarf Silk Banjar', 'price' => '420.000', 'tag' => 'New', 'img' => 'ready-4.jpg']] as $item)
                <div class="group flex flex-col h-full">
                    <div class="relative aspect-[3/4] bg-[#F4F1DE] rounded-2xl overflow-hidden mb-5 shadow-sm">
                        <div
                            class="absolute top-4 left-4 z-10 bg-[#BC6C25] text-[#FEFAE0] text-[8px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                            {{ $item['tag'] }}
                        </div>

                        <img src="{{ asset('storage/images/gallery/' . $item['img']) }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            alt="{{ $item['name'] }}">
                    </div>

                    <div class="flex flex-col flex-grow">
                        <h3 class="text-[12px] font-bold uppercase tracking-widest text-[#283618] mb-1">
                            {{ $item['name'] }}
                        </h3>
                        <p class="text-sm text-[#BC6C25] font-serif italic mb-4">
                            IDR {{ $item['price'] }}
                        </p>

                        <button
                            class="w-full bg-[#283618] text-[#FEFAE0] py-4 rounded-xl text-[9px] font-bold uppercase tracking-[0.2em] transition-all duration-300 hover:bg-[#BC6C25] hover:shadow-lg active:scale-95">
                            Beli Sekarang
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-[#283618] py-24 my-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-16">
                <span class="text-[#DDA15E] text-[10px] font-bold uppercase tracking-[0.4em]">Creative Kit</span>
                <h2
                    class="text-4xl font-serif text-[#FEFAE0] mt-4 leading-tight italic underline decoration-[#BC6C25] underline-offset-8">
                    DIY Kit Sulam Air Guci.</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @foreach ([['name' => 'Starter Pack Kit', 'price' => '275.000', 'level' => 'Beginner', 'img' => 'kit-starter.jpg', 'desc' => 'Lengkap dengan kain velvet, benang emas, dan jarum khusus.'], ['name' => 'Master Class Kit', 'price' => '550.000', 'level' => 'Advanced', 'img' => 'kit-master.jpg', 'desc' => 'Varian motif lebih rumit dengan tambahan manik-manik premium.']] as $kit)
                    <div
                        class="bg-[#FEFAE0]/5 border border-[#FEFAE0]/10 rounded-[2.5rem] overflow-hidden group flex flex-col sm:flex-row items-center">
                        <div class="w-full sm:w-1/2 aspect-square overflow-hidden">
                            <img src="{{ asset('storage/images/gallery/' . $kit['img']) }}"
                                class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                alt="{{ $kit['name'] }}">
                        </div>
                        <div class="p-8 sm:w-1/2 flex flex-col justify-between h-full">
                            <div>
                                <span
                                    class="text-[9px] font-bold text-[#DDA15E] border border-[#DDA15E]/40 px-3 py-1 rounded-full uppercase mb-4 inline-block tracking-widest">{{ $kit['level'] }}</span>
                                <h3 class="text-2xl text-[#FEFAE0] font-serif italic mb-2">{{ $kit['name'] }}</h3>
                                <p class="text-[#FEFAE0]/50 text-xs font-light leading-relaxed mb-6">{{ $kit['desc'] }}
                                </p>
                                <h4 class="text-xl text-[#DDA15E] font-serif mb-6">IDR {{ $kit['price'] }}</h4>
                            </div>
                            <button
                                class="w-full border border-[#FEFAE0]/30 text-[#FEFAE0] py-4 rounded-2xl text-[10px] font-bold uppercase tracking-widest hover:bg-[#FEFAE0] hover:text-[#283618] transition-all">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-24">
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-5xl font-serif text-[#283618] italic mb-4">Riak Experience</h2>
            <div class="w-24 h-[1px] bg-[#BC6C25] mx-auto mb-6"></div>
            <p class="text-[#BC6C25] text-[10px] font-bold uppercase tracking-[0.5em]">
                Curated Cultural Journeys
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
            @foreach ([
        [
            'title' => 'The Golden Banjarmasin',
            'duration' => '3D 2N',
            'price' => '2.499k',
            'img' => 'trip-1.jpg',
            'desc' => 'Menelusuri sungai Barito dan workshop eksklusif langsung bersama Maestro Air Guci.',
        ],
        [
            'title' => 'Martapura Heritage Walk',
            'duration' => '2D 1N',
            'price' => '1.750k',
            'img' => 'trip-2.jpg',
            'desc' => 'Eksplorasi pasar intan dan melihat proses tradisional pembuatan bahan mentah sulaman.',
        ],
    ] as $trip)
                <div
                    class="relative group h-[550px] overflow-hidden rounded-[3rem] shadow-2xl shadow-[#283618]/10 cursor-pointer">
                    <img src="{{ asset('storage/images/gallery/' . $trip['img']) }}"
                        class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-110"
                        alt="{{ $trip['title'] }}">

                    <div
                        class="absolute inset-0 bg-gradient-to-t from-[#283618] via-[#283618]/40 to-transparent transition-opacity duration-500 group-hover:from-[#283618]/90">
                    </div>

                    <div class="absolute inset-0 p-10 md:p-14 flex flex-col justify-end">
                        <div class="flex gap-3 mb-6">
                            <span
                                class="bg-[#BC6C25] text-[#FEFAE0] text-[9px] font-bold px-4 py-2 rounded-full uppercase tracking-widest shadow-lg">
                                {{ $trip['duration'] }}
                            </span>
                            <span
                                class="bg-white/10 backdrop-blur-md border border-white/20 text-[#FEFAE0] text-[9px] font-bold px-4 py-2 rounded-full uppercase tracking-widest">
                                Mulai dari {{ $trip['price'] }}
                            </span>
                        </div>

                        <h3
                            class="text-4xl md:text-5xl font-serif text-[#FEFAE0] mb-6 italic leading-tight transition-transform duration-500 group-hover:-translate-y-2">
                            {{ $trip['title'] }}
                        </h3>

                        <div
                            class="max-h-0 overflow-hidden opacity-0 transition-all duration-700 ease-in-out group-hover:max-h-40 group-hover:opacity-100 group-hover:mb-8">
                            <p class="text-[#FEFAE0]/80 text-sm font-light leading-relaxed max-w-sm">
                                {{ $trip['desc'] }}
                            </p>
                        </div>

                        <button
                            class="w-full bg-[#FEFAE0] text-[#283618] py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] transition-all duration-500 hover:bg-[#BC6C25] hover:text-[#FEFAE0] hover:tracking-[0.4em] shadow-xl">
                            Book Your Experience
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>

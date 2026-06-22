<?php

use App\Models\CreativeKit;
use App\Models\KitVariant;
use App\Models\KitDashboard;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public ?CreativeKit $kit = null;

    public $name_id, $name_en, $level_id, $level_en, $description_id, $description_en, $price, $image, $oldImage, $link_shopee;
    public $variants = [];

    // Properti berkas baru (berupa berkas temporary uploads)
    public $video_url; // Digunakan sebagai file upload gambar instruksi/video
    public $motif_url; // Digunakan sebagai file upload gambar motif

    // Properti untuk melacak berkas lama yang tersimpan di DB saat mode Edit
    public $oldVideoUrl, $oldMotifUrl;

    public function mount($kitId = null)
    {
        if ($kitId) {
            $this->kit = CreativeKit::with(['variants', 'dashboard'])->findOrFail($kitId);
            $this->name_id = $this->kit->name_id;
            $this->name_en = $this->kit->name_en;
            $this->level_id = $this->kit->level_id;
            $this->level_en = $this->kit->level_en;
            $this->description_id = $this->kit->description_id;
            $this->description_en = $this->kit->description_en;
            $this->price = $this->kit->price;
            $this->link_shopee = $this->kit->link_shopee;
            $this->oldImage = $this->kit->image;

            // Memuat gambar dashboard yang sudah ada di database
            if ($this->kit->dashboard) {
                $this->oldVideoUrl = $this->kit->dashboard->video_url;
                $this->oldMotifUrl = $this->kit->dashboard->motif_url;
            }

            foreach ($this->kit->variants as $variant) {
                $this->variants[] = [
                    'id' => $variant->id,
                    'variant_name' => $variant->variant_name,
                ];
            }
        } else {
            $this->addVariant();
        }
    }

    public function addVariant()
    {
        $this->variants[] = ['id' => null, 'variant_name' => ''];
    }

    public function removeVariant($index)
    {
        if (isset($this->variants[$index]['id'])) {
            KitVariant::destroy($this->variants[$index]['id']);
        }

        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    public function save()
    {
        $this->validate(
            [
                'name_id' => 'required|min:3',
                'name_en' => 'required|min:3',
                'level_id' => 'required',
                'level_en' => 'required',
                'description_id' => 'required',
                'description_en' => 'required',
                'price' => 'required|numeric',
                'link_shopee' => 'required|url',
                'image' => $this->kit ? 'nullable|image|max:1024' : 'required|image|max:1024',
                'variants.*.variant_name' => 'required|string|max:255',

                // Validasi diubah ke tipe image berkas karena mengunggah gambar langsung
                'video_url' => $this->oldVideoUrl ? 'nullable|image|max:2048' : 'required|image|max:2048',
                'motif_url' => $this->oldMotifUrl ? 'nullable|image|max:2048' : 'required|image|max:2048',
            ],
            [
                'variants.*.variant_name.required' => 'Nama varian wajib diisi.',
                'video_url.required' => 'Gambar panduan dashboard wajib diunggah.',
                'video_url.image' => 'Berkas panduan video/skema harus berupa gambar.',
                'motif_url.required' => 'Gambar berkas pola motif wajib diunggah.',
                'motif_url.image' => 'Berkas berkas pola motif harus berupa gambar.',
            ],
        );

        $data = [
            'name_id' => $this->name_id,
            'name_en' => $this->name_en,
            'level_id' => $this->level_id,
            'level_en' => $this->level_en,
            'description_id' => $this->description_id,
            'description_en' => $this->description_en,
            'price' => $this->price,
            'link_shopee' => $this->link_shopee,
        ];

        if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $data['image'] = $this->image->store('creative-kits', 'public');
        }

        // 1. Simpan atau update CreativeKit
        $creativeKit = CreativeKit::updateOrCreate(['id' => $this->kit->id ?? null], $data);

        // 2. Siapkan payload path untuk kit_dashboards
        $dashboardData = [];

        // Proses penyimpanan berkas video_url (gambar skema/panduan)
        if ($this->video_url instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $dashboardData['video_url'] = $this->video_url->store('kit-dashboards/guides', 'public');
        } else {
            $dashboardData['video_url'] = $this->oldVideoUrl;
        }

        // Proses penyimpanan berkas motif_url (gambar pola motif)
        if ($this->motif_url instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $dashboardData['motif_url'] = $this->motif_url->store('kit-dashboards/motifs', 'public');
        } else {
            $dashboardData['motif_url'] = $this->oldMotifUrl;
        }

        // Simpan data ke tabel kit_dashboards
        KitDashboard::updateOrCreate(['creative_kit_id' => $creativeKit->id, 'kit_variant_id' => null], $dashboardData);

        // 3. Simpan atau urus data Kit Variants
        $keptIds = [];
        foreach ($this->variants as $variantData) {
            $variant = $creativeKit->variants()->updateOrCreate(['id' => $variantData['id'] ?? null], ['variant_name' => $variantData['variant_name']]);
            $keptIds[] = $variant->id;
        }

        $creativeKit->variants()->whereNotIn('id', $keptIds)->delete();

        session()->flash('message', 'Creative Kit, Varian, dan Aset Dashboard berhasil disimpan.');
        return $this->redirect(route('creative-kit.index'), navigate: true);
    }
}; ?>

<div class="max-w-4xl mx-auto pb-24 px-4">
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-riak-army">{{ $kit ? 'Edit Creative Kit' : 'Create New Kit' }}</h2>
    </x-slot>

    <form wire:submit="save" class="space-y-10">
        {{-- SECTION 1: INFORMASI UTAMA KIT --}}
        <div class="bg-white p-10 rounded-[3rem] border border-riak-honey/10 shadow-sm space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Nama Kit
                        (ID)</label>
                    <input type="text" wire:model="name_id"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('name_id') border-red-400 @enderror">
                    @error('name_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Kit Name
                        (EN)</label>
                    <input type="text" wire:model="name_en"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('name_en') border-red-400 @enderror">
                    @error('name_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Level
                        (ID)</label>
                    <select wire:model="level_id"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('level_id') border-red-400 @enderror">
                        <option value="">Pilih Level</option>
                        <option value="Pemula">Pemula</option>
                        <option value="Menengah">Menengah</option>
                        <option value="Ahli">Ahli</option>
                    </select>
                    @error('level_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Level
                        (EN)</label>
                    <select wire:model="level_en"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('level_en') border-red-400 @enderror">
                        <option value="">Select Level</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                    @error('level_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Price
                        (Rp)</label>
                    <input type="number" wire:model="price"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('price') border-red-400 @enderror">
                    @error('price')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Deskripsi
                        (ID)</label>
                    <textarea wire:model="description_id" rows="4"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('description_id') border-red-400 @enderror"></textarea>
                    @error('description_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Description
                        (EN)</label>
                    <textarea wire:model="description_en" rows="4"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('description_en') border-red-400 @enderror"></textarea>
                    @error('description_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Shopee Link</label>
                <input type="url" wire:model="link_shopee" placeholder="https://shopee.co.id/..."
                    class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('link_shopee') border-red-400 @enderror">
                @error('link_shopee')
                    <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- VARIANTS --}}
            <div class="pt-6 border-t border-riak-honey/10 space-y-4">
                <div class="flex items-center justify-between">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Kit
                        Variants</label>
                    <button type="button" wire:click="addVariant"
                        class="px-4 py-2 bg-riak-cream text-riak-army hover:bg-riak-honey/20 rounded-xl text-[10px] font-bold uppercase tracking-wider transition-all">
                        + Add Variant
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach ($variants as $index => $variant)
                        <div class="flex items-center gap-4" wire:key="variant-field-{{ $index }}">
                            <div class="flex-grow">
                                <input type="text" wire:model="variants.{{ $index }}.variant_name"
                                    placeholder="Contoh: Paket A / Merah / Besar"
                                    class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('variants.' . $index . '.variant_name') border-red-400 @enderror">
                                @error('variants.' . $index . '.variant_name')
                                    <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if (count($variants) > 1)
                                <button type="button" wire:click="removeVariant({{ $index }})"
                                    class="p-3 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-2xl transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24 " stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- VISUALISASI THUMBNAIL UTAMA --}}
            <div class="pt-6 border-t border-riak-honey/10">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey mb-6">Kit
                    Visualization</label>
                <div class="flex items-center gap-10">
                    <div
                        class="relative w-40 h-40 overflow-hidden rounded-3xl border-2 border-riak-honey/30 shadow-md flex-shrink-0">
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif($oldImage)
                            <img src="{{ asset('storage/' . $oldImage) }}" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full bg-riak-cream/30 flex items-center justify-center text-riak-khaki italic text-[10px]">
                                No Image</div>
                        @endif

                        <div wire:loading wire:target="image"
                            class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center">
                            <div
                                class="w-6 h-6 border-2 border-riak-army border-t-transparent rounded-full animate-spin">
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow space-y-3">
                        <input type="file" wire:model="image"
                            class="text-[10px] text-riak-khaki file:mr-6 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-riak-cream file:text-riak-army hover:file:bg-riak-honey/20 transition-all cursor-pointer">
                        <p class="text-[10px] text-riak-khaki italic">High resolution JPG, PNG, or WEBP (Max 1MB)</p>
                        @error('image')
                            <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: DIUBAH KE INPUT UPLOAD GAMBAR DASHBOARD --}}
        <div class="bg-white p-10 rounded-[3rem] border border-riak-honey/10 shadow-sm space-y-10">
            <div class="border-b border-riak-honey/10 pb-2">
                <h3 class="font-serif italic text-lg text-riak-army">Creative Kit Learning Assets</h3>
                <p class="text-[10px] text-riak-khaki mt-0.5">Unggah aset gambar eksklusif panduan & motif yang akan
                    tampil pada dashboard konsumen.</p>
            </div>

            <div class="grid grid-cols-1 gap-10">
                {{-- Input Berkas Gambar Panduan (Video URL Field) --}}
                <div class="space-y-4">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Gambar Skema
                        Panduan / Infografis (Simpan ke video_url)</label>
                    <div class="flex items-start gap-8">
                        <div
                            class="relative w-48 h-32 overflow-hidden rounded-2xl border-2 border-riak-honey/20 bg-gray-50 flex-shrink-0">
                            @if ($video_url)
                                <img src="{{ $video_url->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif($oldVideoUrl)
                                <img src="{{ asset('storage/' . $oldVideoUrl) }}" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center text-riak-khaki italic text-[10px]">
                                    Belum Ada Gambar</div>
                            @endif
                            <div wire:loading wire:target="video_url"
                                class="absolute inset-0 bg-white/80 flex items-center justify-center">
                                <div
                                    class="w-5 h-5 border-2 border-riak-army border-t-transparent rounded-full animate-spin">
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow space-y-2">
                            <input type="file" wire:model="video_url"
                                class="text-[10px] text-riak-khaki file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-riak-cream file:text-riak-army hover:file:bg-riak-honey/20 cursor-pointer">
                            <p class="text-[9px] text-riak-khaki italic">Resolusi tinggi JPG, PNG, atau WEBP (Max 2MB)
                            </p>
                            @error('video_url')
                                <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Input Berkas Gambar Motif (Motif URL Field) --}}
                <div class="space-y-4 pt-6 border-t border-riak-honey/10">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Gambar Pola /
                        Motif Cetak (Simpan ke motif_url)</label>
                    <div class="flex items-start gap-8">
                        <div
                            class="relative w-48 h-32 overflow-hidden rounded-2xl border-2 border-riak-honey/20 bg-gray-50 flex-shrink-0">
                            @if ($motif_url)
                                <img src="{{ $motif_url->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif($oldMotifUrl)
                                <img src="{{ asset('storage/' . $oldMotifUrl) }}" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center text-riak-khaki italic text-[10px]">
                                    Belum Ada Gambar</div>
                            @endif
                            <div wire:loading wire:target="motif_url"
                                class="absolute inset-0 bg-white/80 flex items-center justify-center">
                                <div
                                    class="w-5 h-5 border-2 border-riak-army border-t-transparent rounded-full animate-spin">
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow space-y-2">
                            <input type="file" wire:model="motif_url"
                                class="text-[10px] text-riak-khaki file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-riak-cream file:text-riak-army hover:file:bg-riak-honey/20 cursor-pointer">
                            <p class="text-[9px] text-riak-khaki italic">Resolusi tinggi JPG, PNG, atau WEBP (Max 2MB)
                            </p>
                            @error('motif_url')
                                <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER / ACTIONS --}}
        <div class="flex justify-end items-center gap-8">
            <a href="{{ route('creative-kit.index') }}" wire:navigate
                class="text-[10px] font-bold uppercase tracking-widest text-riak-khaki hover:text-riak-army transition-colors">Discard</a>
            <button type="submit" wire:loading.attr="disabled"
                class="px-14 py-5 bg-riak-army text-riak-cream rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-2xl hover:bg-riak-honey transition-all disabled:opacity-50">
                <span wire:loading.remove wire:target="save">Confirm & Save Kit</span>
                <span wire:loading wire:target="save">Processing...</span>
            </button>
        </div>
    </form>
</div>

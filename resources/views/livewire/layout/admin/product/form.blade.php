<?php

use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\ProductDashboard; // Pastikan Model ini diimport
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public ?Product $product = null;

    // Form Fields Utama
    public $name_id,
        $name_en,
        $price,
        $tag,
        $image,
        $oldImage,
        $link_shopee,
        $total_sold = 0,
        $order = 0;

    // Form Fields Relasi Dinamis (Array)
    public $sizes = [];
    public $variants = [];

    // Form Fields Baru dari tabel product_dashboards
    public $video_url;
    public $sertifikat_url;

    public function mount($productId = null)
    {
        if ($productId) {
            // Load Product beserta dashboard-nya
            $this->product = Product::with(['sizes', 'variants', 'dashboard'])->findOrFail($productId);
            $this->name_id = $this->product->name_id;
            $this->name_en = $this->product->name_en;
            $this->price = $this->product->price;
            $this->tag = $this->product->tag;
            $this->link_shopee = $this->product->link_shopee;
            $this->total_sold = $this->product->total_sold ?? 0;
            $this->order = $this->product->order;
            $this->oldImage = $this->product->image;

            // Load data dari relasi product dashboard jika ada
            if ($this->product->dashboard) {
                $this->video_url = $this->product->dashboard->video_url;
                $this->sertifikat_url = $this->product->dashboard->sertifikat_url;
            }

            // Load data ukuran yang sudah ada
            $this->sizes = $this->product->sizes
                ->map(function ($size) {
                    return ['id' => $size->id, 'size' => $size->size];
                })
                ->toArray();

            // Load data varian yang sudah ada
            $this->variants = $this->product->variants
                ->map(function ($variant) {
                    return ['id' => $variant->id, 'variant_name' => $variant->variant_name];
                })
                ->toArray();
        }

        if (empty($this->sizes)) {
            $this->addSize();
        }
        if (empty($this->variants)) {
            $this->addVariant();
        }
    }

    public function addSize()
    {
        $this->sizes[] = ['id' => null, 'size' => ''];
    }

    public function removeSize($index)
    {
        unset($this->sizes[$index]);
        $this->sizes = array_values($this->sizes);
    }

    public function addVariant()
    {
        $this->variants[] = ['id' => null, 'variant_name' => ''];
    }

    public function removeVariant($index)
    {
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    public function save()
    {
        $this->validate(
            [
                'name_id' => 'required|min:3',
                'name_en' => 'required|min:3',
                'price' => 'required|numeric',
                'tag' => 'required',
                'link_shopee' => 'required|url',
                'image' => $this->product ? 'nullable|image|max:1024' : 'required|image|max:1024',
                'total_sold' => 'required|numeric|min:0',
                'order' => 'required|numeric',
                'sizes.*.size' => 'required|string|max:50',
                'variants.*.variant_name' => 'required|string|max:100',

                // Validasi Tambahan untuk field Dashboard
                'video_url' => 'required|url',
                'sertifikat_url' => 'required|url',
            ],
            [
                'sizes.*.size.required' => 'Opsi ukuran wajib diisi atau hapus baris ini.',
                'variants.*.variant_name.required' => 'Opsi varian wajib diisi atau hapus baris ini.',
                'video_url.required' => 'Link video tutorial wajib diisi untuk dashboard member.',
                'sertifikat_url.required' => 'Link unduhan sertifikat wajib diisi.',
            ],
        );

        $data = [
            'name_id' => $this->name_id,
            'name_en' => $this->name_en,
            'price' => $this->price,
            'tag' => $this->tag,
            'link_shopee' => $this->link_shopee,
            'total_sold' => $this->total_sold,
            'order' => $this->order,
        ];

        if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $data['image'] = $this->image->store('products', 'public');
        }

        // 1. Simpan atau Update Produk Utama
        $product = Product::updateOrCreate(['id' => $this->product->id ?? null], $data);

        // 2. Simpan atau Update Data Dashboard Terkait (Product Dashboard)
        ProductDashboard::updateOrCreate(
            ['product_id' => $product->id],
            [
                'video_url' => $this->video_url,
                'sertifikat_url' => $this->sertifikat_url,
            ],
        );

        // 3. Sinkronisasi Data Ukuran (Product Sizes)
        $keepSizeIds = [];
        foreach ($this->sizes as $sizeData) {
            $size = $product->sizes()->updateOrCreate(['id' => $sizeData['id']], ['size' => $sizeData['size']]);
            $keepSizeIds[] = $size->id;
        }
        $product->sizes()->whereNotIn('id', $keepSizeIds)->delete();

        // 4. Sinkronisasi Data Varian (Product Variants)
        $keepVariantIds = [];
        foreach ($this->variants as $variantData) {
            $variant = $product->variants()->updateOrCreate(['id' => $variantData['id']], ['variant_name' => $variantData['variant_name']]);
            $keepVariantIds[] = $variant->id;
        }
        $product->variants()->whereNotIn('id', $keepVariantIds)->delete();

        session()->flash('message', 'Produk beserta data dashboard berhasil disimpan.');
        return $this->redirect(route('product.index'), navigate: true);
    }
}; ?>

<div class="max-w-4xl mx-auto pb-20 px-4">
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-riak-army">{{ $product ? 'Edit Produk' : 'Tambah Produk Baru' }}</h2>
    </x-slot>

    <form wire:submit="save" class="space-y-8">
        {{-- SECTION 1: DATA UTAMA PRODUK --}}
        <div class="bg-white p-8 rounded-[2.5rem] border border-riak-honey/10 shadow-sm space-y-6">
            <h3 class="font-serif italic text-lg text-riak-army border-b border-riak-honey/10 pb-2">Informasi Produk</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Nama Produk
                        (ID)</label>
                    <input type="text" wire:model="name_id"
                        class="w-full rounded-xl border-riak-honey/20 focus:ring-riak-army @error('name_id') border-red-400 @enderror">
                    @error('name_id')
                        <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Product Name
                        (EN)</label>
                    <input type="text" wire:model="name_en"
                        class="w-full rounded-xl border-riak-honey/20 focus:ring-riak-army @error('name_en') border-red-400 @enderror">
                    @error('name_en')
                        <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Harga
                        (Rp)</label>
                    <input type="number" wire:model="price"
                        class="w-full rounded-xl border-riak-honey/20 focus:ring-riak-army @error('price') border-red-400 @enderror">
                    @error('price')
                        <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Tag</label>
                    <select wire:model="tag"
                        class="w-full rounded-xl border-riak-honey/20 focus:ring-riak-army @error('tag') border-red-400 @enderror">
                        <option value="">Pilih Tag</option>
                        <option value="Upcycled">Upcycled</option>
                        <option value="New">New</option>
                        <option value="Limited">Limited</option>
                    </select>
                    @error('tag')
                        <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Total
                        Terjual</label>
                    <input type="number" wire:model="total_sold" min="0"
                        class="w-full rounded-xl border-riak-honey/20 focus:ring-riak-army @error('total_sold') border-red-400 @enderror">
                    @error('total_sold')
                        <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Urutan</label>
                    <input type="number" wire:model="order"
                        class="w-full rounded-xl border-riak-honey/20 focus:ring-riak-army @error('order') border-red-400 @enderror">
                    @error('order')
                        <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Link Shopee</label>
                <input type="url" wire:model="link_shopee" placeholder="https://shopee.co.id/..."
                    class="w-full rounded-xl border-riak-honey/20 focus:ring-riak-army @error('link_shopee') border-red-400 @enderror">
                @error('link_shopee')
                    <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-riak-honey/10">
                {{-- Opsi Ukuran --}}
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Opsi Ukuran
                            (Sizes)</label>
                        <button type="button" wire:click="addSize"
                            class="px-3 py-1 bg-riak-cream text-riak-army border border-riak-honey/10 rounded-lg text-[9px] font-bold uppercase tracking-wider hover:bg-riak-honey hover:text-riak-cream transition-all">+
                            Tambah Size</button>
                    </div>
                    <div class="space-y-2">
                        @foreach ($sizes as $index => $sizeItem)
                            <div class="flex items-center gap-2" wire:key="size-{{ $index }}">
                                <input type="text" wire:model="sizes.{{ $index }}.size"
                                    placeholder="Contoh: S, M, L"
                                    class="w-full rounded-xl border-riak-honey/20 text-xs font-medium focus:ring-riak-army @error('sizes.' . $index . '.size') border-red-400 @enderror">
                                <button type="button" wire:click="removeSize({{ $index }})"
                                    class="p-2 text-red-400 hover:text-red-600 transition-colors"><svg class="w-4 h-4"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg></button>
                            </div>
                            @error('sizes.' . $index . '.size')
                                <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                            @enderror
                        @endforeach
                    </div>
                </div>

                {{-- Opsi Varian --}}
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Opsi Varian
                            (Variants)</label>
                        <button type="button" wire:click="addVariant"
                            class="px-3 py-1 bg-riak-cream text-riak-army border border-riak-honey/10 rounded-lg text-[9px] font-bold uppercase tracking-wider hover:bg-riak-honey hover:text-riak-cream transition-all">+
                            Tambah Varian</button>
                    </div>
                    <div class="space-y-2">
                        @foreach ($variants as $index => $variantItem)
                            <div class="flex items-center gap-2" wire:key="variant-{{ $index }}">
                                <input type="text" wire:model="variants.{{ $index }}.variant_name"
                                    placeholder="Contoh: Black, Olive"
                                    class="w-full rounded-xl border-riak-honey/20 text-xs font-medium focus:ring-riak-army @error('variants.' . $index . '.variant_name') border-red-400 @enderror">
                                <button type="button" wire:click="removeVariant({{ $index }})"
                                    class="p-2 text-red-400 hover:text-red-600 transition-colors"><svg class="w-4 h-4"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg></button>
                            </div>
                            @error('variants.' . $index . '.variant_name')
                                <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                            @enderror
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Foto Produk --}}
            <div class="pt-4 border-t border-riak-honey/10">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey mb-4">Foto
                    Produk</label>
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <div
                            class="relative w-32 h-32 overflow-hidden rounded-2xl border-2 border-riak-honey shadow-md">
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif($oldImage)
                                <img src="{{ asset('storage/' . $oldImage) }}" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-riak-cream/30 flex items-center justify-center text-riak-khaki">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div wire:loading wire:target="image"
                                class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center">
                                <svg class="animate-spin h-6 w-6 text-riak-army" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <input type="file" wire:model="image" id="upload-1"
                            class="text-xs text-riak-khaki file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-riak-cream file:text-riak-army hover:file:bg-riak-honey/20 transition-all cursor-pointer">
                        <p class="mt-2 text-[10px] text-riak-khaki italic text-opacity-60">Format: JPG, PNG, WEBP
                            (Maks. 1MB)</p>
                        @error('image')
                            <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: INPUT BARU UNTUK MEMBER DASHBOARD RESOURCE (Berdasarkan Migration) --}}
        <div class="bg-white p-8 rounded-[2.5rem] border border-riak-honey/10 shadow-sm space-y-6">
            <div class="border-b border-riak-honey/10 pb-2">
                <h3 class="font-serif italic text-lg text-riak-army">Konten Dashboard Eksklusif</h3>
                <p class="text-[10px] text-riak-khaki mt-0.5">Input ini digunakan untuk memunculkan materi pembelajaran
                    pada kelas online/dashboard member yang mengklaim kode produk ini.</p>
            </div>

            <div class="space-y-4">
                {{-- Input Link Video Tutorial --}}
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Link Video
                        Panduan / Workshop (URL)</label>
                    <input type="url" wire:model="video_url"
                        placeholder="Contoh: https://www.youtube.com/watch?v=... atau link streaming direct"
                        class="w-full rounded-xl border-riak-honey/20 focus:ring-riak-army @error('video_url') border-red-400 @enderror">
                    @error('video_url')
                        <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Link Sertifikat --}}
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Link Unduhan
                        Sertifikat Digital Keaslian (URL)</label>
                    <input type="url" wire:model="sertifikat_url"
                        placeholder="Contoh: https://drive.google.com/file/d/... atau link berkas berkredensial"
                        class="w-full rounded-xl border-riak-honey/20 focus:ring-riak-army @error('sertifikat_url') border-red-400 @enderror">
                    @error('sertifikat_url')
                        <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- TOMBOL SUBMIT FORM --}}
        <div class="flex justify-end items-center gap-6">
            <a href="{{ route('product.index') }}" wire:navigate
                class="text-[10px] font-bold uppercase text-riak-khaki hover:text-riak-army transition-colors">Batal</a>
            <button type="submit" wire:loading.attr="disabled" wire:target="save, image"
                class="relative px-12 py-4 bg-riak-army text-riak-cream rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-xl hover:bg-riak-honey transition-all disabled:opacity-50 disabled:cursor-not-allowed overflow-hidden group">
                <span wire:loading.remove wire:target="save">Simpan Produk & Dashboard</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="animate-spin h-3 w-3 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memproses...
                </span>
            </button>
        </div>
    </form>
</div>

<?php

use App\Models\CreativeKit;
use App\Models\KitVariant; // Pastikan Model ini sudah dibuat
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public ?CreativeKit $kit = null;

    public $name_id, $name_en, $level_id, $level_en, $description_id, $description_en, $price, $image, $oldImage, $link_shopee;
    
    // Properti untuk menampung data variants secara dinamis
    public $variants = [];

    public function mount($kitId = null)
    {
        if ($kitId) {
            $this->kit = CreativeKit::with('variants')->findOrFail($kitId);
            $this->name_id = $this->kit->name_id;
            $this->name_en = $this->kit->name_en;
            $this->level_id = $this->kit->level_id;
            $this->level_en = $this->kit->level_en;
            $this->description_id = $this->kit->description_id;
            $this->description_en = $this->kit->description_en;
            $this->price = $this->kit->price;
            $this->link_shopee = $this->kit->link_shopee;
            $this->oldImage = $this->kit->image;

            // Mengambil variants yang sudah ada di database
            foreach ($this->kit->variants as $variant) {
                $this->variants[] = [
                    'id' => $variant->id,
                    'variant_name' => $variant->variant_name
                ];
            }
        } else {
            // Default: beri 1 baris input kosong saat create baru
            $this->addVariant();
        }
    }

    // Fungsi untuk menambah baris input variant baru di UI
    public function addVariant()
    {
        $this->variants[] = ['id' => null, 'variant_name' => ''];
    }

    // Fungsi untuk menghapus baris input variant dari UI
    public function removeVariant($index)
    {
        // Jika variant sudah ada di DB, hapus dari DB langsung
        if (isset($this->variants[$index]['id'])) {
            KitVariant::destroy($this->variants[$index]['id']);
        }
        
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants); // Reset key array
    }

    public function save()
    {
        $this->validate([
            'name_id' => 'required|min:3',
            'name_en' => 'required|min:3',
            'level_id' => 'required',
            'level_en' => 'required',
            'description_id' => 'required',
            'description_en' => 'required',
            'price' => 'required|numeric',
            'link_shopee' => 'required|url',
            'image' => $this->kit ? 'nullable|image|max:1024' : 'required|image|max:1024',
            
            // Validasi untuk array variants
            'variants.*.variant_name' => 'required|string|max:255',
        ], [
            // Kustomisasi pesan error agar rapi
            'variants.*.variant_name.required' => 'Nama varian wajib diisi.',
        ]);

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

        // 2. Simpan atau urus data Kit Variants
        $keptIds = [];
        foreach ($this->variants as $variantData) {
            $variant = $creativeKit->variants()->updateOrCreate(
                ['id' => $variantData['id'] ?? null],
                ['variant_name' => $variantData['variant_name']]
            );
            $keptIds[] = $variant->id;
        }
        
        // Hapus variant lama yang tidak ada di form saat update
        $creativeKit->variants()->whereNotIn('id', $keptIds)->delete();

        session()->flash('message', 'Creative Kit dan Varian berhasil disimpan.');
        return $this->redirect(route('creative-kit.index'), navigate: true);
    }
}; ?>

<div class="max-w-4xl mx-auto pb-24 px-4">
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-riak-army">{{ $kit ? 'Edit Creative Kit' : 'Create New Kit' }}</h2>
    </x-slot>

    <form wire:submit="save" class="space-y-10">
        <div class="bg-white p-10 rounded-[3rem] border border-riak-honey/10 shadow-sm space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Nama Kit (ID)</label>
                    <input type="text" wire:model="name_id" class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('name_id') border-red-400 @enderror">
                    @error('name_id') <p class="text-red-500 text-[9px] italic">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Kit Name (EN)</label>
                    <input type="text" wire:model="name_en" class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('name_en') border-red-400 @enderror">
                    @error('name_en') <p class="text-red-500 text-[9px] italic">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Level (ID)</label>
                    <select wire:model="level_id" class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('level_id') border-red-400 @enderror">
                        <option value="">Pilih Level</option>
                        <option value="Pemula">Pemula</option>
                        <option value="Menengah">Menengah</option>
                        <option value="Ahli">Ahli</option>
                    </select>
                    @error('level_id') <p class="text-red-500 text-[9px] italic">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Level (EN)</label>
                    <select wire:model="level_en" class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('level_en') border-red-400 @enderror">
                        <option value="">Select Level</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                    @error('level_en') <p class="text-red-500 text-[9px] italic">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Price (Rp)</label>
                    <input type="number" wire:model="price" class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('price') border-red-400 @enderror">
                    @error('price') <p class="text-red-500 text-[9px] italic">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Deskripsi (ID)</label>
                    <textarea wire:model="description_id" rows="4" class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('description_id') border-red-400 @enderror"></textarea>
                    @error('description_id') <p class="text-red-500 text-[9px] italic">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Description (EN)</label>
                    <textarea wire:model="description_en" rows="4" class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('description_en') border-red-400 @enderror"></textarea>
                    @error('description_en') <p class="text-red-500 text-[9px] italic">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Shopee Link</label>
                <input type="url" wire:model="link_shopee" placeholder="https://shopee.co.id/..." class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('link_shopee') border-red-400 @enderror">
                @error('link_shopee') <p class="text-red-500 text-[9px] italic">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 border-t border-riak-honey/10 space-y-4">
                <div class="flex items-center justify-between">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Kit Variants</label>
                    <button type="button" wire:click="addVariant" class="px-4 py-2 bg-riak-cream text-riak-army hover:bg-riak-honey/20 rounded-xl text-[10px] font-bold uppercase tracking-wider transition-all">
                        + Add Variant
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($variants as $index => $variant)
                        <div class="flex items-center gap-4" wire:key="variant-field-{{ $index }}">
                            <div class="flex-grow">
                                <input type="text" wire:model="variants.{{ $index }}.variant_name" placeholder="Contoh: Paket A / Merah / Besar" 
                                    class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('variants.'.$index.'.variant_name') border-red-400 @enderror">
                                @error('variants.'.$index.'.variant_name') 
                                    <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p> 
                                @enderror
                            </div>
                            
                            @if(count($variants) > 1)
                                <button type="button" wire:click="removeVariant({{ $index }})" class="p-3 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-2xl transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-m4-6V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="pt-6 border-t border-riak-honey/10">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey mb-6">Kit Visualization</label>
                <div class="flex items-center gap-10">
                    <div class="relative w-40 h-40 overflow-hidden rounded-3xl border-2 border-riak-honey/30 shadow-md">
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif($oldImage)
                            <img src="{{ asset('storage/' . $oldImage) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-riak-cream/30 flex items-center justify-center text-riak-khaki italic text-[10px]">No Image</div>
                        @endif

                        <div wire:loading wire:target="image" class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center">
                            <div class="w-6 h-6 border-2 border-riak-army border-t-transparent rounded-full animate-spin"></div>
                        </div>
                    </div>
                    <div class="flex-grow space-y-3">
                        <input type="file" wire:model="image" class="text-[10px] text-riak-khaki file:mr-6 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-riak-cream file:text-riak-army hover:file:bg-riak-honey/20 transition-all cursor-pointer">
                        <p class="text-[10px] text-riak-khaki italic">High resolution JPG, PNG, or WEBP (Max 1MB)</p>
                        @error('image') <p class="text-red-500 text-[9px] italic">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end items-center gap-8">
            <a href="{{ route('creative-kit.index') }}" wire:navigate class="text-[10px] font-bold uppercase tracking-widest text-riak-khaki hover:text-riak-army transition-colors">Discard</a>
            <button type="submit" wire:loading.attr="disabled" class="px-14 py-5 bg-riak-army text-riak-cream rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-2xl hover:bg-riak-honey transition-all disabled:opacity-50">
                <span wire:loading.remove wire:target="save">Confirm & Save Kit</span>
                <span wire:loading wire:target="save">Processing...</span>
            </button>
        </div>
    </form>
</div>
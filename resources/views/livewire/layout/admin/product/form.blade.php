<?php

use App\Models\Product;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public ?Product $product = null;

    // Form Fields
    public $name_id,
        $name_en,
        $price,
        $tag,
        $image,
        $oldImage,
        $link_shopee,
        $order = 0;

    public function mount($productId = null)
    {
        if ($productId) {
            $this->product = Product::findOrFail($productId);
            $this->name_id = $this->product->name_id;
            $this->name_en = $this->product->name_en;
            $this->price = $this->product->price;
            $this->tag = $this->product->tag;
            $this->link_shopee = $this->product->link_shopee;
            $this->order = $this->product->order;
            $this->oldImage = $this->product->image;
        }
    }

    public function save()
    {
        $this->validate([
            'name_id' => 'required|min:3',
            'name_en' => 'required|min:3',
            'price' => 'required|numeric',
            'tag' => 'required',
            'link_shopee' => 'required|url',
            'image' => $this->product ? 'nullable|image|max:1024' : 'required|image|max:1024',
            'order' => 'required|numeric',
        ]);

        $data = [
            'name_id' => $this->name_id,
            'name_en' => $this->name_en,
            'price' => $this->price,
            'tag' => $this->tag,
            'link_shopee' => $this->link_shopee,
            'order' => $this->order,
        ];

        if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $data['image'] = $this->image->store('products', 'public');
        }

        Product::updateOrCreate(['id' => $this->product->id ?? null], $data);

        session()->flash('message', 'Produk berhasil disimpan.');
        return $this->redirect(route('product.index'), navigate: true);
    }
}; ?>

<div class="max-w-4xl mx-auto pb-20 px-4">
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-riak-army">{{ $product ? 'Edit Produk' : 'Tambah Produk Baru' }}</h2>
    </x-slot>

    <form wire:submit="save" class="space-y-8">
        <div class="bg-white p-8 rounded-[2.5rem] border border-riak-honey/10 shadow-sm space-y-6">

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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                                        <path
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            <div wire:loading wire:target="image"
                                class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center">
                                <svg class="animate-spin h-6 w-6 text-riak-army" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
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
                        <input type="file" wire:model="image" id="upload-{{ $iteration ?? 1 }}"
                            class="text-xs text-riak-khaki file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-riak-cream file:text-riak-army hover:file:bg-riak-honey/20 transition-all cursor-pointer">
                        <p class="mt-2 text-[10px] text-riak-khaki italic text-opacity-60">Format: JPG, PNG, WEBP (Maks.
                            1MB)</p>
                        @error('image')
                            <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end items-center gap-6">
            <a href="{{ route('product.index') }}" wire:navigate
                class="text-[10px] font-bold uppercase text-riak-khaki hover:text-riak-army transition-colors">Batal</a>

            <button type="submit" wire:loading.attr="disabled" wire:target="save, image"
                class="relative px-12 py-4 bg-riak-army text-riak-cream rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-xl hover:bg-riak-honey transition-all disabled:opacity-50 disabled:cursor-not-allowed overflow-hidden group">

                <span wire:loading.remove wire:target="save">Simpan Produk</span>

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

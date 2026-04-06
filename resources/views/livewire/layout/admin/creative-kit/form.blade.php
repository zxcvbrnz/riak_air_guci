<?php

use App\Models\CreativeKit;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public ?CreativeKit $kit = null;

    public $name_id, $name_en, $level_id, $level_en, $description_id, $description_en, $price, $image, $oldImage, $link_shopee;

    public function mount($kitId = null)
    {
        if ($kitId) {
            $this->kit = CreativeKit::findOrFail($kitId);
            $this->name_id = $this->kit->name_id;
            $this->name_en = $this->kit->name_en;
            $this->level_id = $this->kit->level_id;
            $this->level_en = $this->kit->level_en;
            $this->description_id = $this->kit->description_id;
            $this->description_en = $this->kit->description_en;
            $this->price = $this->kit->price;
            $this->link_shopee = $this->kit->link_shopee;
            $this->oldImage = $this->kit->image;
        }
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

        CreativeKit::updateOrCreate(['id' => $this->kit->id ?? null], $data);

        session()->flash('message', 'Creative Kit berhasil disimpan.');
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

            <div class="pt-6 border-t border-riak-honey/10">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey mb-6">Kit
                    Visualization</label>
                <div class="flex items-center gap-10">
                    <div class="relative w-40 h-40 overflow-hidden rounded-3xl border-2 border-riak-honey/30 shadow-md">
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

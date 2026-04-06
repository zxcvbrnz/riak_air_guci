<?php

use App\Models\Motif;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public ?Motif $motif = null;

    // Form Properties
    public $name_id,
        $name_en,
        $badge,
        $description_id,
        $description_en,
        $image,
        $oldImage,
        $order = 0,
        $is_featured = false;

    public function mount($motifId = null)
    {
        if ($motifId) {
            $this->motif = Motif::findOrFail($motifId);
            $this->name_id = $this->motif->name_id;
            $this->name_en = $this->motif->name_en;
            $this->badge = $this->motif->badge;
            $this->description_id = $this->motif->description_id;
            $this->description_en = $this->motif->description_en;
            $this->order = $this->motif->order;
            $this->is_featured = $this->motif->is_featured;
            $this->oldImage = $this->motif->image;
        }
    }

    public function save()
    {
        $this->validate([
            'name_id' => 'required|min:3',
            'name_en' => 'required|min:3',
            'badge' => 'nullable|string',
            'description_id' => 'required',
            'description_en' => 'required',
            'image' => $this->motif ? 'nullable|image|max:1024' : 'required|image|max:1024',
            'order' => 'required|numeric',
        ]);

        $data = [
            'name_id' => $this->name_id,
            'name_en' => $this->name_en,
            'badge' => $this->badge,
            'description_id' => $this->description_id,
            'description_en' => $this->description_en,
            'order' => $this->order,
            'is_featured' => $this->is_featured,
        ];

        if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $data['image'] = $this->image->store('motifs', 'public');
        }

        Motif::updateOrCreate(['id' => $this->motif->id ?? null], $data);

        session()->flash('message', 'Motif berhasil disimpan.');
        return $this->redirect(route('motif.index'), navigate: true);
    }
}; ?>

<div class="max-w-4xl mx-auto pb-20">
    <x-slot name="header">{{ $motif ? 'Edit Motif' : 'Tambah Motif Baru' }}</x-slot>

    <form wire:submit="save" class="space-y-8">
        <div class="bg-white p-8 rounded-[2.5rem] border border-[#DDA15E]/10 shadow-sm space-y-6">
            <h3 class="font-serif italic text-lg text-[#283618]">Identitas Motif</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Nama Motif
                        (ID)</label>
                    <input type="text" wire:model="name_id"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('name_id') border-red-400 @enderror">
                    @error('name_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Nama Motif
                        (EN)</label>
                    <input type="text" wire:model="name_en"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('name_en') border-red-400 @enderror">
                    @error('name_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Badge
                        (Opsional)</label>
                    <input type="text" wire:model="badge" placeholder="Misal: Signature Motif"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25]">
                    @error('badge')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Urutan
                        (Order)</label>
                    <input type="number" wire:model="order"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('order') border-red-400 @enderror">
                    @error('order')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-[#DDA15E]/10">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Filosofi
                        (ID)</label>
                    <textarea wire:model="description_id" rows="4"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('description_id') border-red-400 @enderror"></textarea>
                    @error('description_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Philosophy
                        (EN)</label>
                    <textarea wire:model="description_en" rows="4"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('description_en') border-red-400 @enderror"></textarea>
                    @error('description_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-[#DDA15E]/10">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25] mb-4">Gambar
                    Motif</label>
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-6">
                        <div class="relative group">
                            @if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                <img src="{{ $image->temporaryUrl() }}"
                                    class="w-32 h-32 object-cover rounded-2xl shadow-md border-2 border-[#BC6C25]">
                            @elseif($oldImage)
                                <img src="{{ asset('storage/' . $oldImage) }}"
                                    class="w-32 h-32 object-cover rounded-2xl border border-[#DDA15E]/20">
                            @else
                                <div
                                    class="w-32 h-32 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            <div wire:loading wire:target="image"
                                class="absolute inset-0 bg-white/70 backdrop-blur-[2px] rounded-2xl flex flex-col items-center justify-center gap-1">
                                <svg class="animate-spin h-5 w-5 text-[#BC6C25]" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-grow">
                            <input type="file" wire:model="image"
                                class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#FEFAE0] file:text-[#283618] hover:file:bg-[#DDA15E]/20">
                            <p class="mt-2 text-[10px] text-gray-400 italic">Format: JPG, PNG, WEBP (Maks. 1MB)</p>
                            @error('image')
                                <p class="text-red-500 text-[9px] font-bold mt-1 tracking-wide">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-[#DDA15E]/10">
                <input type="checkbox" wire:model="is_featured"
                    class="rounded border-[#DDA15E]/40 text-[#BC6C25] focus:ring-[#BC6C25]">
                <label class="text-[10px] font-bold uppercase tracking-widest text-[#283618]">Tampilkan sebagai Motif
                    Unggulan (Featured)</label>
            </div>
        </div>

        <div class="flex justify-end items-center gap-6">
            <a href="{{ route('motif.index') }}" wire:navigate
                class="text-xs font-bold uppercase text-gray-400 hover:text-[#283618] transition-colors">Batal</a>
            <button type="submit" wire:loading.attr="disabled"
                class="px-12 py-4 bg-[#BC6C25] text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-xl shadow-[#BC6C25]/20 hover:bg-[#283618] transition-all transform hover:-translate-y-1">
                <span wire:loading.remove wire:target="save">Simpan Motif</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24">
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

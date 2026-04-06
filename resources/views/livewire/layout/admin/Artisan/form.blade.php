<?php

use App\Models\Artisan;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

new class extends Component {
    use WithFileUploads;

    public ?Artisan $artisan = null;

    public $slug,
        $name,
        $role_id,
        $role_en,
        $quote_id,
        $quote_en,
        $description_id,
        $description_en,
        $photo,
        $oldPhoto,
        $order = 0;

    public function mount($artisanId = null)
    {
        if ($artisanId) {
            $this->artisan = Artisan::findOrFail($artisanId);
            $this->slug = $this->artisan->slug;
            $this->name = $this->artisan->name;
            $this->role_id = $this->artisan->role_id;
            $this->role_en = $this->artisan->role_en;
            $this->quote_id = $this->artisan->quote_id;
            $this->quote_en = $this->artisan->quote_en;
            $this->description_id = $this->artisan->description_id;
            $this->description_en = $this->artisan->description_en;
            $this->order = $this->artisan->order;
            $this->oldPhoto = $this->artisan->photo;
        }
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate([
            'slug' => 'required|unique:artisans,slug,' . ($this->artisan->id ?? 'NULL'),
            'name' => 'required|min:3',
            'role_id' => 'required',
            'role_en' => 'required',
            'quote_id' => 'required',
            'quote_en' => 'required',
            'description_id' => 'required',
            'description_en' => 'required',
            'photo' => $this->artisan ? 'nullable|image|max:1024' : 'required|image|max:1024',
            'order' => 'required|numeric',
        ]);

        $data = [
            'slug' => $this->slug,
            'name' => $this->name,
            'role_id' => $this->role_id,
            'role_en' => $this->role_en,
            'quote_id' => $this->quote_id,
            'quote_en' => $this->quote_en,
            'description_id' => $this->description_id,
            'description_en' => $this->description_en,
            'order' => $this->order,
        ];

        if ($this->photo instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $data['photo'] = $this->photo->store('artisans', 'public');
        }

        Artisan::updateOrCreate(['id' => $this->artisan->id ?? null], $data);

        session()->flash('message', 'Data pengrajin berhasil disimpan.');
        return $this->redirect(route('artisan.index'), navigate: true);
    }
}; ?>

<div class="max-w-4xl mx-auto pb-24 px-4">
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-riak-army">
            {{ $artisan ? 'Edit Profil Pengrajin' : 'Tambah Pengrajin Baru' }}</h2>
    </x-slot>

    <form wire:submit="save" class="space-y-10">
        <div class="bg-white p-10 rounded-[3rem] border border-riak-honey/10 shadow-sm space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Nama
                        Lengkap</label>
                    <input type="text" wire:model.live="name"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('name') border-red-400 @enderror">
                    @error('name')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Slug
                        (Auto)</label>
                    <input type="text" wire:model="slug"
                        class="w-full rounded-2xl bg-gray-50 border-riak-honey/10 text-riak-khaki text-xs" readonly>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Peran (ID) -
                        e.g Maestro Sulam</label>
                    <input type="text" wire:model="role_id"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('role_id') border-red-400 @enderror">
                    @error('role_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Role (EN) - e.g
                        Embroidery Maestro</label>
                    <input type="text" wire:model="role_en"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('role_en') border-red-400 @enderror">
                    @error('role_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-2 w-full md:w-1/3">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Urutan
                    Tampil</label>
                <input type="number" wire:model="order"
                    class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army">
            </div>

            <div class="grid grid-cols-1 gap-6 pt-4 border-t border-riak-honey/5">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey italic">"Quote
                        Utama" (ID)</label>
                    <textarea wire:model="quote_id" rows="2"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army italic font-serif @error('quote_id') border-red-400 @enderror"></textarea>
                    @error('quote_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey italic">"Main
                        Quote" (EN)</label>
                    <textarea wire:model="quote_en" rows="2"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army italic font-serif @error('quote_en') border-red-400 @enderror"></textarea>
                    @error('quote_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Biografi
                        Lengkap (ID)</label>
                    <textarea wire:model="description_id" rows="4"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('description_id') border-red-400 @enderror"></textarea>
                    @error('description_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Full Biography
                        (EN)</label>
                    <textarea wire:model="description_en" rows="4"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('description_en') border-red-400 @enderror"></textarea>
                    @error('description_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-riak-honey/10">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey mb-6">Foto
                    Profil</label>
                <div class="flex items-center gap-10">
                    <div
                        class="relative w-32 h-32 overflow-hidden rounded-full border-2 border-riak-honey shadow-md bg-riak-cream/10">
                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif($oldPhoto)
                            <img src="{{ asset('storage/' . $oldPhoto) }}" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center text-riak-khaki italic text-[10px]">
                                No Photo</div>
                        @endif

                        <div wire:loading wire:target="photo"
                            class="absolute inset-0 bg-white/80 flex items-center justify-center">
                            <div
                                class="w-5 h-5 border-2 border-riak-army border-t-transparent rounded-full animate-spin">
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow space-y-2">
                        <input type="file" wire:model="photo"
                            class="text-[10px] text-riak-khaki file:mr-6 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-riak-cream file:text-riak-army">
                        <p class="text-[10px] text-riak-khaki italic">Rekomendasi ratio 1:1. Maks 1MB.</p>
                        @error('photo')
                            <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end items-center gap-8">
            <a href="{{ route('artisan.index') }}" wire:navigate
                class="text-[10px] font-bold uppercase tracking-widest text-riak-khaki hover:text-riak-army transition-colors">Batal</a>
            <button type="submit" wire:loading.attr="disabled"
                class="px-14 py-5 bg-riak-army text-riak-cream rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-2xl hover:bg-riak-honey transition-all disabled:opacity-50 group">
                <span wire:loading.remove wire:target="save">Simpan Profil</span>
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

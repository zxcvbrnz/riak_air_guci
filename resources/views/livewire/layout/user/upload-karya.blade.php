<?php

use App\Models\CreativeKit;
use App\Models\KitKarya;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public $creative_kit_id;
    public $image_url;

    public function save()
    {
        $this->validate(
            [
                'creative_kit_id' => 'required|exists:creative_kits,id',
                'image_url' => 'required|image|max:3072', // Maksimal 3MB
            ],
            [
                'creative_kit_id.required' => 'Silahkan pilih produk kit terlebih dahulu.',
                'image_url.required' => 'Foto dokumentasi karya wajib diunggah.',
                'image_url.image' => 'Berkas harus berupa gambar (JPG, PNG, WEBP).',
                'image_url.max' => 'Ukuran gambar maksimal adalah 3MB.',
            ],
        );

        // Simpan file ke storage
        $path = $this->image_url->store('kit-karya', 'public');

        // Simpan data ke database
        KitKarya::create([
            'user_id' => auth()->id(),
            'creative_kit_id' => $this->creative_kit_id,
            'image_url' => $path,
            'status' => 'sent',
        ]);

        session()->flash('message', 'Karya Anda berhasil dikirim! Silahkan tunggu proses review oleh tim kami.');

        $this->reset(['creative_kit_id', 'image_url']);
    }

    public function with(): array
    {
        return [
            // Mengambil daftar kit untuk opsi pilihan select form
            'creativeKits' => CreativeKit::select('id', 'name_id')->get(),
        ];
    }
}; ?>

<div class="max-w-3xl mx-auto pb-24 px-4">
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-riak-army">Submit Your Masterpiece</h2>
    </x-slot>

    <div class="space-y-6 mt-6">
        @if (session()->has('message'))
            <div
                class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl text-xs font-medium flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit="save" class="bg-white p-10 rounded-[3rem] border border-riak-honey/10 shadow-sm space-y-8">
            <div>
                <h3 class="font-serif italic text-lg text-riak-army">Pamerkan Karya Kreatifmu</h3>
                <p class="text-[10px] text-riak-khaki mt-0.5">Unggah foto hasil akhir dari perakitan Creative Kit Anda
                    untuk mendapatkan verifikasi resmi.</p>
            </div>

            {{-- Pilih Produk Kit --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Pilih Creative
                    Kit</label>
                <select wire:model="creative_kit_id"
                    class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army text-xs py-3 text-riak-army font-medium @error('creative_kit_id') border-red-400 @enderror">
                    <option value="">-- Pilih Kit yang Telah Diselesaikan --</option>
                    @foreach ($creativeKits as $kit)
                        <option value="{{ $kit->id }}">{{ $kit->name_id }}</option>
                    @endforeach
                </select>
                @error('creative_kit_id')
                    <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Foto Karya --}}
            <div class="space-y-4 pt-4 border-t border-riak-honey/10">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Foto Hasil Karya
                    Anda</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-8">
                    <div
                        class="relative w-full sm:w-48 h-40 overflow-hidden rounded-2xl border-2 border-riak-honey/20 bg-gray-50 flex-shrink-0 flex items-center justify-center">
                        @if ($image_url)
                            <img src="{{ $image_url->temporaryUrl() }}" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full flex flex-col items-center justify-center text-riak-khaki italic text-[10px] p-4 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-riak-khaki/40 mb-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Belum Ada Gambar
                            </div>
                        @endif
                        <div wire:loading wire:target="image_url"
                            class="absolute inset-0 bg-white/80 flex items-center justify-center">
                            <div
                                class="w-5 h-5 border-2 border-riak-army border-t-transparent rounded-full animate-spin">
                            </div>
                        </div>
                    </div>

                    <div class="flex-grow space-y-2 w-full">
                        <input type="file" wire:model="image_url" accept="image/*"
                            class="text-[10px] text-riak-khaki file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-riak-cream file:text-riak-army hover:file:bg-riak-honey/20 cursor-pointer w-full">
                        <p class="text-[9px] text-riak-khaki italic">Format berkas gambar: JPG, PNG, atau WEBP (Maksimal
                            3MB)</p>
                        @error('image_url')
                            <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end pt-4 border-t border-riak-honey/10">
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full sm:w-auto px-10 py-4 bg-riak-army text-riak-cream rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-xl hover:bg-riak-honey transition-all disabled:opacity-50">
                    <span wire:loading.remove wire:target="save">Kirim Karya</span>
                    <span wire:loading wire:target="save">Mengirim Dokumen...</span>
                </button>
            </div>
        </form>
    </div>
</div>

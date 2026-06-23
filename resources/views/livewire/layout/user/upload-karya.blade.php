<?php

use App\Models\CreativeKit;
use App\Models\KitKarya;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

new class extends Component {
    use WithFileUploads, WithPagination;

    public $creative_kit_id;
    public $image_url;

    public function save()
    {
        // Validasi Ganda: Pastikan user tidak menembus form via inspect element
        $hasPending = KitKarya::where('user_id', auth()->id())
            ->whereIn('status', ['sent', 'review'])
            ->exists();

        if ($hasPending) {
            session()->flash('error', 'Anda masih memiliki karya yang sedang dalam proses peninjauan.');
            return;
        }

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
        // Cek apakah ada karya milik user ini yang berstatus 'sent' atau 'review'
        $pendingKarya = KitKarya::where('user_id', auth()->id())
            ->whereIn('status', ['sent', 'review'])
            ->first();

        return [
            'creativeKits' => CreativeKit::select('id', 'name_id')->get(),
            'pendingKarya' => $pendingKarya, // Dilempar ke blade view
            'myKaryas' => KitKarya::with('creativeKit')
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(5, pageName: 'karya-page'),
        ];
    }
}; ?>

<div class="max-w-4xl mx-auto pb-24 px-4 space-y-12">
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-[#283618]">Submit Your Masterpiece</h2>
    </x-slot>

    {{-- Alert Flash Message Global --}}
    <div class="space-y-4 mt-6">
        @if (session()->has('message'))
            <div
                class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl text-xs font-medium flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 flex-shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl text-xs font-medium flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 flex-shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Kondisional: Jika ada karya yang pending, sembunyikan form dan tampilkan status lock --}}
    @if ($pendingKarya)
        <div
            class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-4">
            <div
                class="w-16 h-16 rounded-full flex items-center justify-center {{ $pendingKarya->status === 'sent' ? 'bg-blue-50 text-blue-600' : 'bg-yellow-50 text-yellow-600' }}">
                @if ($pendingKarya->status === 'sent')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 animate-pulse" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 animate-spin-slow" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3-3m0 0l3 3m-3-3v12" />
                    </svg>
                @endif
            </div>

            <div class="max-w-md">
                <h3 class="font-serif italic text-lg text-[#283618]">Pengunggahan Dikunci Sementara</h3>
                <p class="text-[11px] text-gray-500 mt-2">
                    Anda sudah mengirimkan karya untuk <span
                        class="font-bold">{{ $pendingKarya->creativeKit->name_id ?? 'Creative Kit' }}</span>.
                    Saat ini berkas Anda berstatus <span
                        class="uppercase font-mono px-2 py-0.5 rounded text-[10px] font-bold {{ $pendingKarya->status === 'sent' ? 'bg-blue-50 text-blue-600' : 'bg-yellow-50 text-yellow-700' }}">{{ $pendingKarya->status }}</span>.
                </p>
                <p class="text-[10px] text-gray-400 italic mt-3">Formulir upload baru akan terbuka kembali setelah tim
                    admin memberikan keputusan (Approved / Rejected) pada karya Anda di bawah.</p>
            </div>
        </div>
    @else
        {{-- 1. FORM UPLOAD KARYA (HANYA MUNCUL JIKA TIDAK ADA PENDING KARYA) --}}
        <form wire:submit="save" class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm space-y-8">
            <div>
                <h3 class="font-serif italic text-lg text-[#283618]">Pamerkan Karya Kreatifmu</h3>
                <p class="text-[10px] text-gray-400 mt-0.5">Unggah foto hasil akhir dari perakitan Creative Kit Anda
                    untuk mendapatkan verifikasi resmi.</p>
            </div>

            {{-- Pilih Produk Kit --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#DDA15E]">Pilih Creative
                    Kit</label>
                <select wire:model="creative_kit_id"
                    class="w-full rounded-2xl border-gray-200 focus:ring-[#283618] focus:border-[#283618] text-xs py-3 text-[#283618] font-medium @error('creative_kit_id') border-red-400 @enderror">
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
            <div class="space-y-4 pt-4 border-t border-gray-100">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#DDA15E]">Foto Hasil Karya
                    Anda</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-8">
                    <div
                        class="relative w-full sm:w-48 h-40 overflow-hidden rounded-2xl border-2 border-gray-100 bg-gray-50 flex-shrink-0 flex items-center justify-center">
                        @if ($image_url)
                            <img src="{{ $image_url->temporaryUrl() }}" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full flex flex-col items-center justify-center text-gray-400 italic text-[10px] p-4 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300 mb-1"
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
                                class="w-5 h-5 border-2 border-[#283618] border-t-transparent rounded-full animate-spin">
                            </div>
                        </div>
                    </div>

                    <div class="flex-grow space-y-2 w-full">
                        <input type="file" wire:model="image_url" accept="image/*"
                            class="text-[10px] text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-[#FEFAE0] file:text-[#283618] hover:file:bg-[#DDA15E]/20 cursor-pointer w-full">
                        <p class="text-[9px] text-gray-400 italic">Format berkas gambar: JPG, PNG, atau WEBP (Maksimal
                            3MB)</p>
                        @error('image_url')
                            <p class="text-red-500 text-[9px] italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full sm:w-auto px-10 py-4 bg-[#283618] text-[#FEFAE0] rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-xl hover:bg-[#DDA15E] transition-all disabled:opacity-50">
                    <span wire:loading.remove wire:target="save">Kirim Karya</span>
                    <span wire:loading wire:target="save">Mengirim Dokumen...</span>
                </button>
            </div>
        </form>
    @endif

    {{-- 2. TABEL DAFTAR STATUS KARYA YANG SUDAH DIUPLOAD --}}
    <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-gray-100">
            <h3 class="font-serif italic text-lg text-[#283618]">Riwayat Unggahan Anda</h3>
            <p class="text-[10px] text-gray-400 mt-0.5">Pantau status peninjauan dan verifikasi karya yang telah Anda
                kirimkan.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-[#DDA15E] w-32">Foto</th>
                        <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-[#DDA15E]">Creative Kit</th>
                        <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-[#DDA15E]">Tanggal Unggah
                        </th>
                        <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-[#DDA15E]">Status Verifikasi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($myKaryas as $karya)
                        <tr class="hover:bg-gray-50/40 transition-colors" wire:key="my-karya-{{ $karya->id }}">
                            <td class="p-6">
                                <div class="w-20 h-16 rounded-xl overflow-hidden border border-gray-100 bg-gray-50">
                                    <img src="{{ asset('storage/' . $karya->image_url) }}"
                                        class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="p-6 text-xs font-bold text-[#283618]">
                                {{ $karya->creativeKit->name_id ?? 'Kit Terhapus' }}
                            </td>
                            <td class="p-6 text-xs text-gray-500">
                                {{ $karya->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="p-6">
                                @if ($karya->status === 'sent')
                                    <span
                                        class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-100">Sent
                                        (Menunggu)</span>
                                @elseif($karya->status === 'review')
                                    <span
                                        class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-yellow-50 text-yellow-600 border border-yellow-100">Sedang
                                        Direview</span>
                                @elseif($karya->status === 'approved')
                                    <span
                                        class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-green-50 text-green-600 border border-green-100">Approved
                                        (Disetujui)</span>
                                @else
                                    <span
                                        class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-red-50 text-red-600 border border-red-100">Rejected
                                        (Ditolak)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center text-gray-400 italic text-xs">
                                Anda belum pernah mengunggah dokumentasi karya.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($myKaryas->hasPages())
            <div class="p-6 border-t border-gray-100 bg-gray-50/30">
                {{ $myKaryas->links() }}
            </div>
        @endif
    </div>
</div>

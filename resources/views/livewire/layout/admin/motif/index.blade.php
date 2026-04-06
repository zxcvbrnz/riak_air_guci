<?php

use App\Models\Motif;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public function delete($id)
    {
        $motif = Motif::findOrFail($id);

        // Hapus file gambar dari storage jika ada
        if ($motif->image) {
            Storage::disk('public')->delete($motif->image);
        }

        $motif->delete();
        session()->flash('message', 'Motif berhasil dihapus.');
    }

    public function with()
    {
        return [
            'motifs' => Motif::orderBy('order', 'asc')->paginate(10),
        ];
    }
}; ?>

<div class="max-w-6xl mx-auto pb-20">
    <x-slot name="header">Kelola Motif</x-slot>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h2 class="font-serif italic text-3xl text-[#283618]">Daftar Motif</h2>
            <p class="text-xs font-bold uppercase tracking-widest text-[#BC6C25] mt-1">Kelola Koleksi Motif & Filosofi
                Banjar</p>
        </div>

        <a href="{{ route('motif.create') }}" wire:navigate
            class="inline-flex items-center justify-center px-8 py-3 bg-[#283618] text-[#FEFAE0] rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg hover:bg-[#BC6C25] transition-all transform hover:-translate-y-1">
            + Tambah Motif Baru
        </a>
    </div>

    @if (session()->has('message'))
        <div
            class="mb-6 p-4 bg-[#FEFAE0] border border-[#DDA15E]/20 text-[#606C38] rounded-2xl text-xs font-bold uppercase tracking-wider">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($motifs as $motif)
            <div
                class="bg-white rounded-[2.5rem] border border-[#DDA15E]/10 shadow-sm overflow-hidden group hover:shadow-xl hover:shadow-[#DDA15E]/5 transition-all duration-500">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('storage/' . $motif->image) }}" alt="{{ $motif->name_id }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                    @if ($motif->is_featured)
                        <div
                            class="absolute top-4 left-4 bg-[#BC6C25] text-white text-[8px] font-bold uppercase px-3 py-1 rounded-full shadow-lg">
                            Featured
                        </div>
                    @endif

                    @if ($motif->badge)
                        <div
                            class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-md text-[#283618] text-[8px] font-bold uppercase px-3 py-1 rounded-full border border-[#DDA15E]/20">
                            {{ $motif->badge }}
                        </div>
                    @endif
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[9px] font-bold text-[#BC6C25] uppercase tracking-tighter">Order:
                                {{ $motif->order }}</span>
                            <h4 class="font-serif italic text-xl text-[#283618] leading-tight">{{ $motif->name_id }}
                            </h4>
                            <p class="text-[10px] text-gray-400 font-medium uppercase mt-1">{{ $motif->name_en }}</p>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                        {{ $motif->description_id }}
                    </p>

                    <div class="flex items-center justify-between pt-4 border-t border-[#DDA15E]/10">
                        <a href="{{ route('motif.edit', $motif->id) }}" wire:navigate
                            class="text-[10px] font-bold uppercase text-[#606C38] hover:text-[#BC6C25] transition-colors">
                            Edit Data
                        </a>

                        <button type="button" wire:click="delete({{ $motif->id }})"
                            wire:confirm="Apakah Anda yakin ingin menghapus motif ini?"
                            class="text-[10px] font-bold uppercase text-red-400 hover:text-red-600 transition-colors">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="col-span-full py-20 text-center bg-white rounded-[2.5rem] border border-dashed border-[#DDA15E]/30">
                <p class="text-sm font-serif italic text-gray-400">Belum ada data motif yang tersimpan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $motifs->links() }}
    </div>
</div>

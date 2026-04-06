<?php

use App\Models\Video;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public function delete($id)
    {
        $video = Video::findOrFail($id);
        if ($video->thumb) {
            Storage::disk('public')->delete($video->thumb);
        }
        $video->delete();
        session()->flash('message', 'Video berhasil dihapus.');
    }
}; ?>

<div class="space-y-6">
    <x-slot name="header">Kelola Koleksi Video</x-slot>

    <div class="flex justify-between items-center">
        <h2 class="font-serif italic text-xl text-[#283618]">Daftar Video</h2>
        <a href="{{ route('video.create') }}" wire:navigate
            class="px-6 py-2 bg-[#BC6C25] text-white rounded-xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-[#BC6C25]/20 hover:bg-[#283618] transition-all">
            + Tambah Video
        </a>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-green-100 text-green-700 rounded-2xl text-xs font-bold uppercase tracking-wider">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-[2rem] border border-[#DDA15E]/10 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#FEFAE0]/50 border-b border-[#DDA15E]/10">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Thumbnail</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Judul</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Kategori</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Durasi</th>
                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#BC6C25] text-right">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#DDA15E]/5">
                @foreach (Video::latest()->paginate(10) as $video)
                    <tr class="hover:bg-[#FEFAE0]/20 transition-colors">
                        <td class="px-6 py-4">
                            <img src="{{ asset('storage/' . $video->thumb) }}"
                                class="w-20 h-12 object-cover rounded-lg shadow-sm">
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-[#283618]">{{ $video->title_id }}</p>
                            <p class="text-[10px] text-gray-400 italic">{{ $video->title_en }}</p>
                        </td>
                        <td class="px-6 py-4 text-xs text-[#283618]">
                            <span class="px-3 py-1 bg-[#DDA15E]/10 rounded-full border border-[#DDA15E]/20">
                                {{ $video->category_id }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-mono text-gray-500">{{ $video->duration }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('video.edit', $video->id) }}" wire:navigate
                                class="text-[#BC6C25] hover:text-[#283618] transition-colors">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button onclick="confirm('Hapus video ini?') || event.stopImmediatePropagation()"
                                wire:click="delete({{ $video->id }})"
                                class="text-red-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 bg-[#FEFAE0]/30">
            {{ Video::latest()->paginate(10)->links() }}
        </div>
    </div>
</div>

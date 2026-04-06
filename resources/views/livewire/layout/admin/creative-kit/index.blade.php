<?php

use App\Models\CreativeKit;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithPagination;

    public function delete($id)
    {
        $kit = CreativeKit::findOrFail($id);
        if ($kit->image) {
            Storage::disk('public')->delete($kit->image);
        }
        $kit->delete();
        session()->flash('message', 'Creative Kit berhasil dihapus.');
    }

    public function with()
    {
        return [
            'kits' => CreativeKit::latest()->paginate(10),
        ];
    }
}; ?>

<div class="max-w-7xl mx-auto pb-20 px-6">
    <x-slot name="header">Kelola Creative Kits</x-slot>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h2 class="font-serif italic text-3xl text-[#283618]">Daftar Creative Kits</h2>
            <p class="text-xs font-bold uppercase tracking-widest text-[#BC6C25] mt-1">Kelola Koleksi Creative Kits &
                Educational Kits</p>
        </div>

        <a href="{{ route('creative-kit.create') }}" wire:navigate
            class="inline-flex items-center justify-center px-8 py-3 bg-[#283618] text-[#FEFAE0] rounded-2xl text-xs font-bold uppercase tracking-widest shadow-lg hover:bg-[#BC6C25] transition-all transform hover:-translate-y-1">
            + Tambah Creative Kit Baru
        </a>
    </div>

    @if (session()->has('message'))
        <div
            class="mb-8 p-5 bg-riak-cream border border-riak-honey/20 text-riak-army rounded-2xl text-[10px] font-bold uppercase tracking-widest flex items-center gap-3">
            <span class="w-2 h-2 bg-riak-honey rounded-full animate-pulse"></span>
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] border border-riak-honey/10 overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-riak-cream/30 border-b border-riak-honey/10">
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Preview</th>
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Kit Details
                    </th>
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Level</th>
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Price</th>
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-riak-honey/5">
                @forelse ($kits as $kit)
                    <tr class="group hover:bg-riak-cream/10 transition-colors">
                        <td class="px-8 py-5">
                            <div class="w-20 h-20 rounded-2xl overflow-hidden border border-riak-honey/10 shadow-sm">
                                <img src="{{ asset('storage/' . $kit->image) }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="font-serif italic text-xl text-riak-army">{{ $kit->name_id }}</div>
                            <div class="text-[10px] text-riak-khaki uppercase tracking-tighter mt-1">{{ $kit->name_en }}
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span
                                class="px-4 py-1.5 rounded-full bg-white text-riak-army text-[9px] font-bold uppercase tracking-widest border border-riak-honey/20 shadow-sm">
                                {{ $kit->level_id }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-sm font-bold text-riak-army">
                            Rp {{ number_format($kit->price, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('creative-kit.edit', $kit->id) }}" wire:navigate
                                    class="p-2 text-riak-army hover:text-riak-honey transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.5 2.5 0 113.536 3.536L12 14.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <button wire:click="delete({{ $kit->id }})" wire:confirm="Hapus kit ini?"
                                    class="p-2 text-red-400 hover:text-red-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center font-serif italic text-riak-khaki text-lg">
                            No creative kits found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-10">
        {{ $kits->links() }}
    </div>
</div>

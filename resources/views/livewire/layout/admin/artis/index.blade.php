<?php

use App\Models\Artisan;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithPagination;

    public function delete($id)
    {
        $artisan = Artisan::findOrFail($id);
        if ($artisan->photo) {
            Storage::disk('public')->delete($artisan->photo);
        }
        $artisan->delete();
        session()->flash('message', 'Data pengrajin berhasil dihapus.');
    }

    public function with()
    {
        return [
            'artisans' => Artisan::orderBy('order', 'asc')->paginate(10),
        ];
    }
}; ?>

<div class="max-w-7xl mx-auto pb-20 px-6">
    <x-slot name="header">Kelola Artisan</x-slot>
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12 border-b border-riak-honey/10 pb-10">
        <div>
            <h2 class="font-serif italic text-5xl text-riak-army">The Artisans</h2>
            <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-riak-honey mt-3">Manajemen Profil Pengrajin &
                Tokoh</p>
        </div>

        <a href="{{ route('artisan.create') }}" wire:navigate
            class="px-10 py-4 bg-riak-army text-riak-cream rounded-full text-[10px] font-bold uppercase tracking-widest shadow-xl hover:bg-riak-honey transition-all transform hover:-translate-y-1">
            + Tambah Pengrajin
        </a>
    </div>

    @if (session()->has('message'))
        <div
            class="mb-8 p-5 bg-riak-cream border border-riak-honey/20 text-riak-army rounded-2xl text-[10px] font-bold uppercase tracking-widest flex items-center gap-3 shadow-sm">
            <span class="w-2 h-2 bg-riak-honey rounded-full animate-pulse"></span>
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] border border-riak-honey/10 overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-riak-cream/30 border-b border-riak-honey/10">
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Profil</th>
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Nama & Peran
                    </th>
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Order</th>
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey text-right">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-riak-honey/5">
                @forelse ($artisans as $artisan)
                    <tr class="group hover:bg-riak-cream/10 transition-colors">
                        <td class="px-8 py-5">
                            <div
                                class="w-16 h-16 rounded-full overflow-hidden border-2 border-riak-honey/20 shadow-sm bg-riak-cream/30">
                                <img src="{{ asset('storage/' . $artisan->photo) }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="font-serif italic text-xl text-riak-army">{{ $artisan->name }}</div>
                            <div class="text-[9px] text-riak-honey font-bold uppercase tracking-widest mt-1">
                                {{ $artisan->role_id }} / <span class="opacity-60">{{ $artisan->role_en }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-sm font-serif italic text-riak-khaki">
                            #{{ $artisan->order }}
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('artisan.edit', $artisan->id) }}" wire:navigate
                                    class="p-2 text-riak-army hover:text-riak-honey transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.5 2.5 0 113.536 3.536L12 14.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <button wire:click="delete({{ $artisan->id }})"
                                    wire:confirm="Hapus data pengrajin ini?"
                                    class="p-2 text-red-400 hover:text-red-600 transition-all">
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
                        <td colspan="4" class="px-8 py-24 text-center font-serif italic text-riak-khaki text-lg">
                            Belum ada data pengrajin.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

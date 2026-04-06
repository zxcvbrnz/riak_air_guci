<?php

use App\Models\MovementSchool;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithPagination;

    public function delete($id)
    {
        $item = MovementSchool::findOrFail($id);
        if ($item->media_path) {
            Storage::disk('public')->delete($item->media_path);
        }
        $item->delete();
        session()->flash('message', 'Data Movement School berhasil dihapus.');
    }

    public function with()
    {
        return [
            'schools' => MovementSchool::orderBy('order', 'asc')->paginate(10),
        ];
    }
}; ?>

<div class="max-w-7xl mx-auto pb-20 px-6">
    <x-slot name="header">Kelola Movement School</x-slot>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12 border-b border-riak-honey/10 pb-10">
        <div>
            <h2 class="font-serif italic text-5xl text-riak-army">Movement Schools</h2>
            <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-riak-honey mt-3">Manage Educational Programs
                & Series</p>
        </div>

        <a href="{{ route('movement-school.create') }}" wire:navigate
            class="px-10 py-4 bg-riak-army text-riak-cream rounded-full text-[10px] font-bold uppercase tracking-widest shadow-xl hover:bg-riak-honey transition-all transform hover:-translate-y-1">
            + Add New
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
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Media</th>
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Label & Title
                    </th>
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey text-center">
                        Type</th>
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Order</th>
                    <th class="px-8 py-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-riak-honey/5">
                @forelse ($schools as $school)
                    <tr class="group hover:bg-riak-cream/10 transition-colors">
                        <td class="px-8 py-5">
                            <div
                                class="w-24 h-16 rounded-xl overflow-hidden border border-riak-honey/10 shadow-sm bg-gray-50 relative">
                                <img src="{{ asset('storage/' . $school->media_path) }}"
                                    class="w-full h-full object-cover">
                                @if ($school->type === 'video')
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-[9px] font-bold uppercase tracking-widest text-riak-honey">
                                {{ $school->label_id }}</div>
                            <div class="font-serif italic text-lg text-riak-army mt-0.5">{{ $school->title_id }}</div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span
                                class="px-3 py-1 rounded-full bg-white text-riak-khaki text-[8px] font-bold uppercase tracking-widest border border-riak-honey/10">
                                {{ $school->type }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-sm font-serif italic text-riak-army">
                            #{{ $school->order }}
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('movement-school.edit', $school->id) }}" wire:navigate
                                    class="p-2 text-riak-army hover:text-riak-honey transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.5 2.5 0 113.536 3.536L12 14.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <button wire:click="delete({{ $school->id }})" wire:confirm="Hapus program ini?"
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
                            No movement school data found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-10">
        {{ $schools->links() }}
    </div>
</div>

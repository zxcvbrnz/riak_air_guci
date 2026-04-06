<?php

use App\Models\CulturalTrip;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    public function delete($id)
    {
        $trip = CulturalTrip::findOrFail($id);
        if ($trip->image) {
            Storage::disk('public')->delete($trip->image);
        }
        $trip->delete();
        session()->flash('message', 'Trip berhasil dihapus.');
    }

    public function with()
    {
        return [
            'trips' => CulturalTrip::withCount(['batches', 'rutes'])
                ->latest()
                ->get(),
        ];
    }
}; ?>

<div class="space-y-6">
    <x-slot name="header">Kelola Cultural Trip</x-slot>

    <div class="flex justify-between items-center">
        <h2 class="text-xl font-serif italic text-[#283618]">Daftar Paket Perjalanan</h2>
        <a href="{{ route('trip.create') }}" wire:navigate
            class="bg-[#283618] text-[#FEFAE0] px-6 py-2 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-[#BC6C25] transition-all">
            Tambah Trip Baru
        </a>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-green-100 text-green-700 rounded-2xl text-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-sm border border-[#DDA15E]/10 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#FEFAE0]/50 border-b border-[#DDA15E]/10">
                <tr>
                    <th class="px-6 py-4 text-[10px] uppercase tracking-widest font-bold text-[#BC6C25]">Trip</th>
                    <th class="px-6 py-4 text-[10px] uppercase tracking-widest font-bold text-[#BC6C25]">Info</th>
                    <th class="px-6 py-4 text-[10px] uppercase tracking-widest font-bold text-[#BC6C25]">Status</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#DDA15E]/5">
                @foreach ($trips as $trip)
                    <tr class="hover:bg-[#FEFAE0]/20 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $trip->image) }}"
                                    class="w-12 h-12 rounded-lg object-cover">
                                <div>
                                    <span class="block font-serif text-[#283618]">{{ $trip->title_id }}</span>
                                    <span class="text-[10px] text-gray-400">{{ $trip->slug }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-[#283618]">
                            <span class="block">Durasi: {{ $trip->duration }}</span>
                            <span class="block font-bold text-[#BC6C25]">IDR {{ $trip->price_display }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <span
                                    class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-[9px] font-bold">{{ $trip->batches_count }}
                                    Batch</span>
                                <span
                                    class="px-2 py-1 bg-orange-50 text-orange-600 rounded text-[9px] font-bold">{{ $trip->rutes_count }}
                                    Rute</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('trip.edit', $trip->id) }}" wire:navigate
                                class="text-[#BC6C25] hover:text-[#283618] transition-colors">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button wire:click="delete({{ $trip->id }})" wire:confirm="Hapus trip ini?"
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
    </div>
</div>

<?php

use App\Models\KitKarya;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $statusFilter = '';

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updateStatus($id, $newStatus)
    {
        $karya = KitKarya::findOrFail($id);
        $karya->update([
            'status' => $newStatus,
        ]);

        session()->flash('message', 'Status karya berhasil diperbarui menjadi ' . strtoupper($newStatus));
    }

    public function with(): array
    {
        $karyas = KitKarya::with(['user', 'creativeKit'])
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return [
            'karyas' => $karyas,
        ];
    }
}; ?>

<div class="max-w-6xl mx-auto pb-24 px-4">
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-riak-army">Verifikasi Karya User</h2>
    </x-slot>

    <div class="space-y-6 mt-6">
        {{-- Flash Alert Message --}}
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

        {{-- Filter Bagian Status Atas --}}
        <div
            class="bg-white p-6 rounded-[2rem] border border-riak-honey/10 shadow-sm flex items-center justify-between gap-4">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-riak-honey">Filter Status Verifikasi</p>
            </div>
            <select wire:model.live="statusFilter"
                class="w-48 rounded-2xl border-riak-honey/20 focus:ring-riak-army text-xs py-2.5 text-riak-army font-medium">
                <option value="">Semua Status</option>
                <option value="sent">Sent (Baru)</option>
                <option value="review">Review</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        {{-- TABEL DATA KARYA + INJEKSI GLOBAL STATE ALPINE.JS UNTUK MODAL PREVIEW --}}
        <div class="bg-white rounded-[3rem] border border-riak-honey/10 shadow-sm overflow-hidden"
            x-data="{ openPreview: false, previewSrc: '' }">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-riak-honey/10 bg-riak-cream/10">
                            <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey w-36">
                                Pratinjau</th>
                            <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Kreator &
                                Kit</th>
                            <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Tanggal
                                Kirim</th>
                            <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey">Status</th>
                            <th class="p-6 text-[10px] font-bold uppercase tracking-widest text-riak-honey text-right">
                                Aksi Penilaian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-riak-honey/5">
                        @forelse ($karyas as $karya)
                            <tr class="hover:bg-riak-cream/5 transition-colors"
                                wire:key="karya-row-{{ $karya->id }}">

                                {{-- Thumbnail Karya dengan Trigger Klik Pembesar --}}
                                <td class="p-6">
                                    <button type="button"
                                        @click="previewSrc = '{{ asset('storage/' . $karya->image_url) }}'; openPreview = true"
                                        class="block w-24 h-20 rounded-xl overflow-hidden border border-riak-honey/20 bg-gray-100 group relative cursor-zoom-in text-left focus:outline-none">
                                        <img src="{{ asset('storage/' . $karya->image_url) }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                                        {{-- Overlay Icon Zoom Saat Hover --}}
                                        <div
                                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                    </button>
                                </td>

                                {{-- Identitas Kreator User & Jenis Kit --}}
                                <td class="p-6">
                                    <h4 class="text-xs font-bold text-riak-army">
                                        {{ $karya->user->name ?? 'User Terhapus' }}</h4>
                                    <p class="text-[10px] text-riak-khaki font-mono">{{ $karya->user->email ?? '-' }}
                                    </p>
                                    <div
                                        class="mt-2 text-[10px] font-medium text-riak-honey bg-riak-cream/40 inline-block px-2.5 py-1 rounded-lg">
                                        Kit: {{ $karya->creativeKit->name_id ?? 'Kit Terhapus' }}
                                    </div>
                                </td>

                                {{-- Tanggal Input Kirim --}}
                                <td class="p-6 text-xs text-riak-khaki">
                                    {{ $karya->created_at->translatedFormat('d M Y, H:i') }}
                                </td>

                                {{-- Status Verifikasi Saat Ini --}}
                                <td class="p-6">
                                    @if ($karya->status === 'sent')
                                        <span
                                            class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-100">Sent</span>
                                    @elseif($karya->status === 'review')
                                        <span
                                            class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-yellow-50 text-yellow-600 border border-yellow-100">Review</span>
                                    @elseif($karya->status === 'approved')
                                        <span
                                            class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-green-50 text-green-600 border border-green-100">Approved</span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider bg-red-50 text-red-600 border border-red-100">Rejected</span>
                                    @endif
                                </td>

                                {{-- Tombol Aksi Kendali Evaluasi Admin --}}
                                <td class="p-6 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if ($karya->status === 'sent')
                                            <button wire:click="updateStatus({{ $karya->id }}, 'review')"
                                                class="px-3 py-1.5 bg-gray-100 text-riak-army hover:bg-yellow-100 hover:text-yellow-700 rounded-xl text-[9px] font-bold uppercase tracking-wider transition-all">
                                                Review
                                            </button>
                                        @endif

                                        @if ($karya->status !== 'approved')
                                            <button wire:click="updateStatus({{ $karya->id }}, 'approved')"
                                                class="px-3 py-1.5 bg-green-50 text-green-700 hover:bg-green-600 hover:text-white rounded-xl text-[9px] font-bold uppercase tracking-wider border border-green-200 transition-all">
                                                Approve
                                            </button>
                                        @endif

                                        @if ($karya->status !== 'rejected')
                                            <button wire:click="updateStatus({{ $karya->id }}, 'rejected')"
                                                class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-xl text-[9px] font-bold uppercase tracking-wider border border-red-200 transition-all">
                                                Reject
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-16 text-center text-riak-khaki italic text-xs">
                                    Tidak ada data karya yang perlu diverifikasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Navigasi Pagination Halaman --}}
            @if ($karyas->hasPages())
                <div class="p-6 border-t border-riak-honey/10 bg-riak-cream/5">
                    {{ $karyas->links() }}
                </div>
            @endif

            {{-- INTERACTIVE LIGHTBOX MODAL OVERLAY (ALPINJS) --}}
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
                x-show="openPreview" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" @keydown.escape.window="openPreview = false" style="display: none;">

                {{-- Tombol Silang (X) di Pojok Atas Layar --}}
                <button type="button" @click="openPreview = false"
                    class="absolute top-6 right-6 text-white/70 hover:text-white transition-colors focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                {{-- Box Gambar Utama --}}
                <div class="relative max-w-4xl max-h-[85vh] overflow-hidden rounded-2xl shadow-2xl"
                    @click.away="openPreview = false">
                    <img :src="previewSrc"
                        class="w-full h-auto max-h-[85vh] object-contain rounded-2xl border border-white/10">
                </div>
            </div>

        </div>
    </div>
</div>

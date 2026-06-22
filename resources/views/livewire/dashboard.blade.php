<?php

use Illuminate\Support\Facades\Auth;
use App\Models\UniqueCode;
use App\Models\ProductDashboard;
use App\Models\KitDashboard;
use App\Models\KitVariant;
use Livewire\Volt\Component;

new class extends Component {
    public $uniqueCode;
    public $type; // 'product' atau 'kit'
    public $dashboardData = null;
    public $itemDetail = null; // Menampung objek Product atau CreativeKit
    public $chosenVariantName = null;

    public function mount()
    {
        // 1. Ambil data member dan unique code dari user yang sedang login
        $user = Auth::user();

        if (!$user || !$user->member || !$user->member->uniqueCode) {
            // Jika user tidak punya kode unik, properti tetap null
            return;
        }

        // 2. Load UniqueCode beserta relasi-relasinya
        $this->uniqueCode = UniqueCode::with(['product', 'creativeKit'])->find($user->member->unique_code_id);
        $this->type = $this->uniqueCode->type;

        // 3. Ambil data dashboard berdasarkan tipe (Product atau Kit)
        if ($this->type === 'product') {
            $this->itemDetail = $this->uniqueCode->product;

            if ($this->itemDetail) {
                $this->dashboardData = ProductDashboard::where('product_id', $this->itemDetail->id)->first();
            }
        } elseif ($this->type === 'kit') {
            $this->itemDetail = $this->uniqueCode->creativeKit;
            $this->chosenVariantName = $this->uniqueCode->kit_variant;

            if ($this->itemDetail) {
                // Cari ID varian berdasarkan string nama varian yang disimpan di unique_codes
                $variant = KitVariant::where('creative_kit_id', $this->itemDetail->id)->where('variant_name', $this->chosenVariantName)->first();

                // Query dashboard: Utamakan yang spesifik ke variant_id tersebut.
                // Jika tidak ada dashboard khusus varian, ambil dashboard umum untuk kit tersebut (variant_id null)
                $this->dashboardData = KitDashboard::where('creative_kit_id', $this->itemDetail->id)
                    ->where(function ($query) use ($variant) {
                        if ($variant) {
                            $query->where('kit_variant_id', $variant->id)->orWhereNull('kit_variant_id');
                        } else {
                            $query->whereNull('kit_variant_id');
                        }
                    })
                    ->orderByRaw('kit_variant_id DESC') // Mendahulukan yang NOT NULL (spesifik varian)
                    ->first();
            }
        }
    }
}; ?>

<div class="max-w-7xl mx-auto pb-24 px-4 sm:px-6 lg:px-8 pt-10">
    {{-- KONDISI 1: JIKA USER BELUM MEMILIKI / MENGKLAIM KODE UNIK --}}
    @if (!$uniqueCode)
        <div class="bg-amber-50 border border-amber-200 rounded-[2rem] p-10 text-center max-w-2xl mx-auto shadow-sm">
            <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m0-6V9m0 12a9 9 0 110-18 9 9 0 010 18z" />
                </svg>
            </div>
            <h2 class="font-serif italic text-2xl text-riak-army mb-2">Dashboard Belum Tersedia</h2>
            <p class="text-sm text-riak-khaki mb-6">Anda belum mengklaim atau mendaftarkan Unique Code milik Anda.
                Silakan hubungi admin atau masukkan kode unik Anda terlebih dahulu untuk melihat materi pembelajaran.
            </p>
        </div>
    @else
        {{-- KONDISI 2: JIKA KODE UNIK ADA, TAPI DASHBOARD BELUM DISET OLEH ADMIN --}}
        @if (!$dashboardData)
            <div
                class="bg-white border border-riak-honey/10 rounded-[2rem] p-12 text-center max-w-2xl mx-auto shadow-sm">
                <h2 class="font-serif italic text-3xl text-riak-army mb-3">Materi Sedang Disiapkan</h2>
                <p class="text-xs font-bold uppercase tracking-widest text-riak-honey mb-4">
                    {{ $type === 'kit' ? 'Creative Kit:' : 'Produk:' }} {{ $itemDetail->name_id ?? $itemDetail->name }}
                </p>
                <p class="text-sm text-riak-khaki">Halo! Panduan video, sertifikat, atau motif untuk item ini belum
                    diunggah oleh admin kami. Mohon ditunggu atau hubungi layanan bantuan jika ini merupakan kekeliruan.
                </p>
            </div>
        @else
            {{-- KONDISI 3: DASHBOARD BERHASIL DIMUAT (UTAMA) --}}
            <div class="space-y-10">
                <div class="border-b border-riak-honey/10 pb-6">
                    <span
                        class="px-3 py-1 bg-riak-cream text-riak-army text-[10px] font-bold uppercase tracking-widest rounded-full border border-riak-honey/20">
                        {{ $type === 'kit' ? 'Creative Kit Member' : 'Exclusive Product Member' }}
                    </span>
                    <h1 class="font-serif italic text-4xl text-riak-army mt-4">Welcome to Your Workshop</h1>
                    <p class="text-xs text-riak-khaki mt-2">
                        Materi eksklusif untuk: <span
                            class="font-bold text-riak-army">{{ $itemDetail->name_id ?? $itemDetail->name }}</span>
                        @if ($chosenVariantName)
                            | Varian: <span class="font-bold text-riak-honey">{{ $chosenVariantName }}</span>
                        @endif
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-black rounded-[2.5rem] overflow-hidden shadow-2xl aspect-video relative group">
                            {{-- Mengonversi link youtube biasa ke format embed jika diperlukan, atau langsung render iframe --}}
                            @if (str_contains($dashboardData->video_url, 'youtube.com') || str_contains($dashboardData->video_url, 'youtu.be'))
                                @php
                                    // Helper sederhana ekstrak ID Youtube
                                    preg_match(
                                        '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
                                        $dashboardData->video_url,
                                        $match,
                                    );
                                    $youtubeId = $match[1] ?? null;
                                @endphp
                                @if ($youtubeId)
                                    <iframe class="w-full h-full"
                                        src="https://www.youtube.com/embed/{{ $youtubeId }}" title="Tutorial Video"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center text-white bg-neutral-900 text-sm">
                                        Link Video Error</div>
                                @endif
                            @else
                                <video class="w-full h-full" controls>
                                    <source src="{{ $dashboardData->video_url }}" type="video/mp4">
                                    Browser Anda tidak mendukung pemutar video html5.
                                </video>
                            @endif
                        </div>

                        <div class="bg-white p-8 rounded-[2rem] border border-riak-honey/10 shadow-sm">
                            <h3 class="font-serif italic text-xl text-riak-army mb-2">Panduan Penggunaan & Kelas Online
                            </h3>
                            <p class="text-xs text-riak-khaki leading-relaxed">Tonton video tutorial di atas dengan
                                saksama untuk memahami langkah demi langkah pembuatan atau perawatan produk Anda.
                                Pastikan koneksi internet Anda stabil untuk kualitas video terbaik.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white p-8 rounded-[2rem] border border-riak-honey/10 shadow-sm space-y-6">
                            <h3 class="font-serif italic text-xl text-riak-army">Exclusive Downloads</h3>
                            <p class="text-[11px] text-riak-khaki -mt-4 leading-relaxed">Berikut berkas lampiran resmi
                                pelengkap produk yang bisa Anda unduh dan cetak secara mandiri.</p>

                            {{-- JIKA DATA ADALAH PRODUCT (Tampilkan Unduh Sertifikat) --}}
                            @if ($type === 'product' && isset($dashboardData->sertifikat_url))
                                <div
                                    class="p-5 bg-riak-cream/30 border border-riak-honey/10 rounded-2xl flex items-center justify-between gap-4 group hover:bg-riak-cream/50 transition-colors">
                                    <div class="space-y-1">
                                        <h4 class="text-xs font-bold text-riak-army uppercase tracking-wider">Sertifikat
                                            Keaslian</h4>
                                        <p class="text-[10px] text-riak-khaki">Certificate of Authenticity (PDF)</p>
                                    </div>
                                    <a href="{{ $dashboardData->sertifikat_url }}" target="_blank" download
                                        class="p-3 bg-riak-army text-riak-cream rounded-xl shadow-md hover:bg-riak-honey transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                </div>
                            @endif

                            {{-- JIKA DATA ADALAH CREATIVE KIT (Tampilkan Unduh Motif) --}}
                            @if ($type === 'kit' && isset($dashboardData->motif_url))
                                <div
                                    class="p-5 bg-riak-cream/30 border border-riak-honey/10 rounded-2xl flex items-center justify-between gap-4 group hover:bg-riak-cream/50 transition-colors">
                                    <div class="space-y-1">
                                        <h4 class="text-xs font-bold text-riak-army uppercase tracking-wider">E-Pattern
                                            & Motif</h4>
                                        <p class="text-[10px] text-riak-khaki">Motif Cetak Panduan Kit (PDF/Image)</p>
                                    </div>
                                    <a href="{{ $dashboardData->motif_url }}" target="_blank" download
                                        class="p-3 bg-riak-army text-riak-cream rounded-xl shadow-md hover:bg-riak-honey transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                </div>
                            @endif

                            <div class="pt-4 border-t border-riak-honey/10 space-y-2">
                                <span class="text-[9px] font-bold uppercase tracking-widest text-riak-honey block">Kode
                                    Terverifikasi</span>
                                <div
                                    class="p-3 bg-gray-50 border border-gray-100 rounded-xl font-mono text-center text-xs font-bold tracking-wider text-gray-600">
                                    {{ $uniqueCode->code }}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        @endif
    @endif
</div>

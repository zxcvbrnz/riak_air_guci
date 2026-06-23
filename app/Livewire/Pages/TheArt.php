<?php

namespace App\Livewire\Pages;

use App\Models\KitKarya;
use Livewire\Component;

class TheArt extends Component
{
    /**
     * Me-render halaman galeri dengan data karya yang sudah di-approve.
     * Menggunakan Eager Loading (with) untuk mencegah masalah N+1 query.
     */
    public function render()
    {
        // Ambil semua karya dengan status approved beserta relasi user dan creativeKit
        $approvedKaryas = KitKarya::with(['user', 'creativeKit'])
            ->where('status', 'approved')
            ->latest()
            ->get();

        // Kelompokkan karya berdasarkan nama produk Creative Kit
        $groupedKaryas = $approvedKaryas->groupBy(function ($karya) {
            return $karya->creativeKit->name_id ?? 'Creative Kit Collection';
        });

        return view('livewire.pages.the-art', [
            'groupedKaryas' => $groupedKaryas,
        ]);
    }
}

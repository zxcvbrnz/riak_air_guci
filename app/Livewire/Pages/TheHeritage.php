<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Motif;

class TheHeritage extends Component
{
    public function render()
    {
        // Ambil semua motif, urutkan, lalu kelompokkan berdasarkan 'badge'
        $groupedMotifs = Motif::orderBy('order')->get()->groupBy('badge');

        return view('livewire.pages.the-heritage', [
            'groupedMotifs' => $groupedMotifs,
        ]);
    }
}
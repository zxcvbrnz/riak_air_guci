<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class TheHeritage extends Component
{
    public function render()
    {
        $motifs = \App\Models\Motif::orderBy('order')->get(); // Ambil semua motif dari database, urutkan berdasarkan kolom 'order'
        return view('livewire.pages.the-heritage', [
            'motifs' => $motifs,
        ]);
    }
}

<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $videos = \App\Models\Video::all(); // Ambil semua video dari database
        return view('livewire.pages.home', [
            'videos' => $videos,
        ]);
    }
}

<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class TheMovement extends Component
{
    public function render()
    {
        $schools = \App\Models\MovementSchool::orderBy('order')->get();

        $artisans = \App\Models\Artisan::orderBy('order')->get();

        return view('livewire.pages.the-movement', [
            'schools' => $schools,
            'artisans' => $artisans
        ]);
    }
}

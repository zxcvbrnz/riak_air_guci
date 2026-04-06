<?php

namespace App\Livewire\Pages;

use App\Models\MovementSchool;
use Livewire\Component;

class MovementDetail extends Component
{
    public MovementSchool $school;

    public function mount(MovementSchool $movementSchool)
    {
        // Livewire otomatis mencari berdasarkan slug karena {movementSchool:slug} di route
        $this->school = $movementSchool;
    }

    public function render()
    {
        return view('livewire.pages.movement-detail');
    }
}

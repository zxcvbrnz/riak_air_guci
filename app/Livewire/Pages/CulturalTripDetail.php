<?php

namespace App\Livewire\Pages;

use App\Models\CulturalTrip;
use Livewire\Component;

class CulturalTripDetail extends Component
{
    public CulturalTrip $trip;

    public function mount($slug)
    {
        // Menggunakan Eager Loading agar query lebih efisien
        $this->trip = CulturalTrip::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.pages.cultural-trip-detail');
    }
}

<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class TheGallery extends Component
{
    public function render()
    {
        $products = \App\Models\Product::orderBy('order')->get();
        $kits = \App\Models\CreativeKit::orderBy('id')->get();
        $trpis = \App\Models\CulturalTrip::orderBy('id')->get();
        return view('livewire.pages.the-gallery', [
            'products' => $products,
            'kits' => $kits,
            'trips' => $trpis,
        ]);
    }
}

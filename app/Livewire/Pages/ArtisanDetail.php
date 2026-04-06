<?php

namespace App\Livewire\Pages;

use App\Models\Artisan;
use Livewire\Component;

class ArtisanDetail extends Component
{
    public Artisan $artisan;

    public function mount(Artisan $artisan)
    {
        $this->artisan = $artisan;
    }

    public function render()
    {
        return view('livewire.pages.artisan-detail');
    }
}

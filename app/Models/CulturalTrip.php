<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CulturalTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_id',
        'title_en',
        'duration',
        'price_display',
        'description_id',
        'description_en',
        'image'
    ];

    // Accessor untuk Judul Trip
    public function getTitleAttribute()
    {
        $locale = App::getLocale();
        return $this->{"title_{$locale}"} ?? $this->title_id;
    }

    // Accessor untuk Deskripsi Trip
    public function getDescriptionAttribute()
    {
        $locale = App::getLocale();
        return $this->{"description_{$locale}"} ?? $this->description_id;
    }
}

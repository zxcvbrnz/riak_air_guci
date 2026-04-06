<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

class CulturalTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title_id',
        'title_en',
        'duration',
        'price_display',
        'description_id',
        'description_en',
        'image'
    ];

    public function batches(): HasMany
    {
        return $this->hasMany(TripBatch::class);
    }
    public function rutes(): HasMany
    {
        return $this->hasMany(TripRute::class)->orderBy('order', 'asc');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
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

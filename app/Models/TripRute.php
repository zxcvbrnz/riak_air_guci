<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripRute extends Model
{
    protected $fillable = ['cultural_trip_id', 'title_id', 'title_en', 'description_id', 'description_en', 'order'];

    public function culturalTrip()
    {
        return $this->belongsTo(CulturalTrip::class);
    }

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"} ?? $this->title_id;
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"description_{$locale}"} ?? $this->description_id;
    }
}

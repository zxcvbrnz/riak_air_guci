<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripBatch extends Model
{
    protected $fillable = ['cultural_trip_id', 'departure_date', 'available_seats'];
    public function culturalTrip()
    {
        return $this->belongsTo(CulturalTrip::class);
    }
}

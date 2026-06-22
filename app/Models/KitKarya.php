<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KitKarya extends Model
{
    protected $fillable = [
        'creative_kit_id',
        'kit_variant_id',
        'video_url',
        'motif_url',
    ];

    public function creativeKit()
    {
        return $this->belongsTo(CreativeKit::class);
    }

    public function kitVariant()
    {
        return $this->belongsTo(KitVariant::class);
    }
}

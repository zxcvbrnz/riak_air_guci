<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KitVariant extends Model
{
    protected $fillable = [
        'creative_kit_id',
        'variant_name',
    ];

    public function creativeKit()
    {
        return $this->belongsTo(CreativeKit::class);
    }
    public function dashboards()
    {
        return $this->hasMany(KitDashboard::class);
    }
}

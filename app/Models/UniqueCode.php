<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniqueCode extends Model
{
    protected $fillable = [
        'type',
        'creative_kit_id',
        'kit_variant',
        'product_id',
        'code',
        'is_used',
    ];

    // relasi ke product dengan many-to-one
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function creativeKit()
    {
        return $this->belongsTo(CreativeKit::class);
    }
    public function member()
    {
        return $this->hasOne(Member::class);
    }
}

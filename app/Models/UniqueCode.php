<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniqueCode extends Model
{
    protected $fillable = [
        'product_id',
        'code'
    ];

    // relasi ke product dengan many-to-one
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function member()
    {
        return $this->hasOne(Member::class);
    }
}

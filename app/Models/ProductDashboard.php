<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDashboard extends Model
{
    protected $fillable = [
        'product_id',
        'video_url',
        'sertifikat_url',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

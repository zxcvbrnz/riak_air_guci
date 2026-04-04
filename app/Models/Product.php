<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_id',
        'name_en',
        'price',
        'tag',
        'image',
        'link_shopee',
        'order'
    ];

    // Accessor untuk Nama Otomatis (ID/EN)
    public function getNameAttribute()
    {
        $locale = App::getLocale();
        return $this->{"name_{$locale}"} ?? $this->name_id;
    }
}

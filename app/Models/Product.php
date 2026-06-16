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

    public function getNameAttribute()
    {
        $locale = App::getLocale();
        return $this->{"name_{$locale}"} ?? $this->name_id;
    }

    public function uniqueCodes()
    {
        return $this->hasMany(UniqueCode::class);
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
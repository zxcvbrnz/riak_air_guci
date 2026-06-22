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
        'order',
        'total_sold',
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

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function dashboards()
    {
        return $this->hasOne(ProductDashboard::class);
    }
}

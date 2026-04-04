<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CreativeKit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_id',
        'name_en',
        'level_id',
        'level_en',
        'description_id',
        'description_en',
        'price',
        'image',
        'link_shopee',
    ];

    // Accessor untuk Nama
    public function getNameAttribute()
    {
        $locale = App::getLocale();
        return $this->{"name_{$locale}"} ?? $this->name_id;
    }

    // Accessor untuk Level (Beginner/Pemula)
    public function getLevelAttribute()
    {
        $locale = App::getLocale();
        return $this->{"level_{$locale}"} ?? $this->level_id;
    }

    // Accessor untuk Deskripsi
    public function getDescriptionAttribute()
    {
        $locale = App::getLocale();
        return $this->{"description_{$locale}"} ?? $this->description_id;
    }
}

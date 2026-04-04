<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Motif extends Model
{
    protected $fillable = [
        'image',
        'badge',
        'name_id',
        'name_en',
        'description_id',
        'description_en',
        'order',
        'is_featured',
    ];

    /**
     * Accessor untuk Nama (Otomatis ID/EN)
     */
    public function getNameAttribute()
    {
        $locale = App::getLocale(); // Mengambil locale aktif (id atau en)
        $column = "name_{$locale}";
        return $this->{$column} ?? $this->name_id;
    }

    /**
     * Accessor untuk Deskripsi (Otomatis ID/EN)
     */
    public function getDescriptionAttribute()
    {
        $locale = App::getLocale();
        $column = "description_{$locale}";
        return $this->{$column} ?? $this->description_id;
    }
}

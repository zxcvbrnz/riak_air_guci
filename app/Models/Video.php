<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Video extends Model
{
    protected $fillable = [
        'title_id',
        'title_en',
        'category_id',
        'category_en',
        'duration',
        'thumb',
        'video_url',
        'is_featured',
    ];

    /**
     * Accessor untuk Title (Otomatis ID/EN)
     */
    public function getTitleAttribute()
    {
        $locale = App::getLocale(); // Mengambil locale aktif (id atau en)
        $column = "title_{$locale}";
        return $this->{$column} ?? $this->title_id; // Fallback ke title_id jika title_en tidak tersedia
    }
    /**
     * Accessor untuk Category (Otomatis ID/EN)
     */
    public function getCategoryAttribute()
    {
        $locale = App::getLocale();
        $column = "category_{$locale}";
        return $this->{$column} ?? $this->category_id; // Fallback ke category_id jika category_en tidak tersedia
    }
}

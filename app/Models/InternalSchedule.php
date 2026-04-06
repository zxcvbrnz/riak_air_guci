<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class InternalSchedule extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi (Mass Assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title_id',
        'title_en',
        'date',
        'location_id',
        'location_en',
        'is_completed',
        'order'
    ];

    /**
     * Casting atribut ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'is_completed' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Accessor untuk mendapatkan Judul sesuai bahasa aktif.
     * Contoh penggunaan: $schedule->title
     */
    public function getTitleAttribute(): string
    {
        $locale = App::getLocale();
        return $this->{"title_{$locale}"} ?? $this->title_id;
    }

    /**
     * Accessor untuk mendapatkan Lokasi sesuai bahasa aktif.
     * Contoh penggunaan: $schedule->location
     */
    public function getLocationAttribute(): string
    {
        $locale = App::getLocale();
        return $this->{"location_{$locale}"} ?? $this->location_id;
    }

    /**
     * Scope untuk mengambil agenda yang akan datang (Upcoming).
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString())
            ->where('is_completed', false)
            ->orderBy('date', 'asc');
    }

    /**
     * Scope untuk mengambil agenda yang sudah selesai.
     */
    public function scopeFinished($query)
    {
        return $query->where('is_completed', true)
            ->orWhere('date', '<', now()->toDateString())
            ->orderBy('date', 'desc');
    }
}

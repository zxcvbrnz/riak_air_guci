<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Artisan extends Model
{
    protected $fillable = ['name', 'role_id', 'role_en', 'quote_id', 'quote_en', 'description_id', 'description_en', 'photo', 'order'];

    public function getRoleAttribute()
    {
        return App::getLocale() == 'en' ? $this->role_en : $this->role_id;
    }

    public function getQuoteAttribute()
    {
        return App::getLocale() == 'en' ? $this->quote_en : $this->quote_id;
    }

    public function getDescriptionAttribute()
    {
        return App::getLocale() == 'en' ? $this->description_en : $this->description_id;
    }
}

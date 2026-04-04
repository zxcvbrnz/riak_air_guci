<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class MovementSchool extends Model
{
    protected $fillable = ['label_id', 'label_en', 'title_id', 'title_en', 'description_id', 'description_en', 'media_path', 'type', 'video_url', 'order'];

    public function getLabelAttribute()
    {
        return App::getLocale() == 'en' ? $this->label_en : $this->label_id;
    }

    public function getTitleAttribute()
    {
        return App::getLocale() == 'en' ? $this->title_en : $this->title_id;
    }

    public function getDescriptionAttribute()
    {
        return App::getLocale() == 'en' ? $this->description_en : $this->description_id;
    }
}

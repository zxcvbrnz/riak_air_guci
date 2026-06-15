<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'unique_code_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uniqueCode()
    {
        return $this->belongsTo(UniqueCode::class);
    }
}

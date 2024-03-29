<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libraries extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class,'libraries_auth');
    }

    public function books()
    {
        return $this->hasMany(Books::class);
    }
}

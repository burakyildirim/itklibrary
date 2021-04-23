<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Levels extends Model
{
    use HasFactory;

    public function ebooks()
    {
        return $this->belongsToMany(DigitalBooks::class,'level_digital_book','level_id','digital_book_id');
    }
}

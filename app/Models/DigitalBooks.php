<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalBooks extends Model
{
    use HasFactory;

    public function levels()
    {
        return $this->belongsToMany(Levels::class, 'level_digital_book', 'digital_book_id', 'level_id');
    }
}

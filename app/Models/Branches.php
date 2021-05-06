<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    use HasFactory;

    public function ebooks()
    {
        return $this->belongsToMany(DigitalBooks::class,'branch_digital_book','branch_id','digital_book_id');
    }
}

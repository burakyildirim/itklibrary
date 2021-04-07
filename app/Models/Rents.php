<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rents extends Model
{
    use HasFactory;

    public const RentStatuses = [
        1 => 'Kütüphaneci Onayı Bekliyor',
        2 => 'Kitap Alıcıda',
        3 => 'Kitap Kütüphaneye Teslim Edildi',
        4 => 'Kitap Kütüphaneye Teslim Edilmedi'
    ];

    public static function getRentStatusID($status)
    {
        return array_search($status, self::RentStatuses);
    }

    public function user(){
        return $this->belongsTo(User::class, 'users_id')->select('id', 'name');
    }

    public function book(){
        return $this->belongsTo(Books::class, 'books_id')->select('id', 'book_name', 'book_image','book_author','book_stok','book_language');
    }
}

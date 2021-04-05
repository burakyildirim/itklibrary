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
        3 => 'Kitap Kutuphaneye Teslim Edildi',
        4 => 'Kitap Kutuphaneye Teslim Edilmedi'
    ];

    public static function getRentStatusID($status)
    {
        return array_search($status, self::RentStatuses);
    }
}

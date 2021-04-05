<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    public const Languages = [
        1 => 'TÜRKÇE',
        2 => 'İNGİLİZCE',
        3 => 'ALMANCA',
        4 => 'FRANSIZCA',
        5 => 'İSPANYOLCA',
        6 => 'İTALYANCA',
        7 => 'DİĞER'
    ];

    public const VisStatus = [
        1 => 'GÖRÜNÜR',
        0 => 'GÖRÜNMEZ'
    ];

    public const RentStatus = [
        1 => 'UYGUN',
        0 => 'UYGUN DEĞİL'
    ];

    /**
     * Kitap dilinin ID değerini döner.
     *
     * @param string $language  user's role
     * @return int languageID
     */
    public static function getLanguageID($language)
    {
        return array_search($language, self::Languages);
    }

    /**
     * Kitap Görünürlük ID değerini döner.
     *
     * @param string $language  user's role
     * @return int languageID
     */
    public static function getVisStatusID($visStatus)
    {
        return array_search($visStatus, self::VisStatus);
    }

    /**
     * Kitap Kiralanabilirlik Durumu ID değerini döner.
     *
     * @param string $language  user's role
     * @return int languageID
     */
    public static function getRentStatusID($rentStatus)
    {
        return array_search($rentStatus, self::RentStatus);
    }

    public function library(){
        return $this->belongsTo(Libraries::class, 'libraries_id')->select('id', 'libraries_name');
    }
}

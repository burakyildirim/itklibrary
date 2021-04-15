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

    public const Rafs = [
        'A' =>'A',
        'B' =>'B',
        'C' =>'C',
        'D' =>'D',
        'E' =>'E',
        'F' =>'F',
        'G' =>'G',
        'H' =>'H',
        'I' =>'I',
        'J' =>'J',
        'K' =>'K',
        'L' =>'L',
        'M' =>'M',
        'N' =>'N',
        'O' =>'O',
        'P' =>'P',
        'R' =>'R',
        'S' =>'S',
        'T' =>'T',
        'U' =>'U',
        'V' =>'V',
        'Y' =>'Y',
        'Z' =>'Z'
    ];

    public const Siras = [
        '1' =>'1',
        '2' =>'2',
        '3' =>'3',
        '4' =>'4',
        '5' =>'5',
        '6' =>'6',
        '7' =>'7',
        '8' =>'8',
        '9' =>'9',
        '10' =>'10',
        '11' =>'11',
        '12' =>'12',
        '13' =>'13',
        '14' =>'14',
        '15' =>'15',
        '16' =>'16',
        '17' =>'17',
        '18' =>'18',
        '19' =>'20',
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

    public function rent(){
        return $this->belongsToMany(Rents::class)->get();
    }
}

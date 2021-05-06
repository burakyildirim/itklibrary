<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            [
                'branch_name' => 'Almanca',
                'branch_slug' => 'almanca'
            ],
            [
                'branch_name' => 'Beden Eğitimi',
                'branch_slug' => 'beden-egitimi'
            ],
            [
                'branch_name' => 'Bilişim Teknolojileri',
                'branch_slug' => 'bilisim-teknolojileri'
            ],
            [
                'branch_name' => 'Biyoloji',
                'branch_slug' => 'biyoloji'
            ],
            [
                'branch_name' => 'Coğrafya',
                'branch_slug' => 'cografya'
            ],
            [
                'branch_name' => 'Din Kül. ve Ahl. Bilgisi',
                'branch_slug' => 'din-kulturu-ve-ahlak'
            ],
            [
                'branch_name' => 'Felsefe',
                'branch_slug' => 'felsefe'
            ],
            [
                'branch_name' => 'Fen Bilimleri',
                'branch_slug' => 'fen-bilimleri'
            ],
            [
                'branch_name' => 'Fizik',
                'branch_slug' => 'fizik'
            ],
            [
                'branch_name' => 'Fransızca',
                'branch_slug' => 'fransizca'
            ],
            [
                'branch_name' => 'Geometri',
                'branch_slug' => 'geometri'
            ],
            [
                'branch_name' => 'Görsel Sanatlar',
                'branch_slug' => 'gorsel-sanatlar'
            ],
            [
                'branch_name' => 'Hayat Bilgisi',
                'branch_slug' => 'hayat-bilgisi'
            ],
            [
                'branch_name' => 'İngilizce',
                'branch_slug' => 'ingilizce-english'
            ],
            [
                'branch_name' => 'İspanyolca',
                'branch_slug' => 'ispanyolca'
            ],
            [
                'branch_name' => 'Kimya',
                'branch_slug' => 'kimya'
            ],
            [
                'branch_name' => 'Matematik',
                'branch_slug' => 'matematik'
            ],
            [
                'branch_name' => 'Müzik',
                'branch_slug' => 'muzik'
            ],
            [
                'branch_name' => 'PDR',
                'branch_slug' => 'psikoloji-pdr'
            ],
            [
                'branch_name' => 'Satranç',
                'branch_slug' => 'satranc'
            ],
            [
                'branch_name' => 'Sosyal Bilgiler',
                'branch_slug' => 'sosyal-bilgiler'
            ],
            [
                'branch_name' => 'STEM',
                'branch_slug' => 'fen-stem'
            ],
            [
                'branch_name' => 'Tarih',
                'branch_slug' => 'tarih'
            ],
            [
                'branch_name' => 'Türk Dili ve Edebiyatı',
                'branch_slug' => 'turk-dili-ve-edebiyati'
            ],
            [
                'branch_name' => 'Türkçe',
                'branch_slug' => 'turkce'
            ]
        ]);
    }
}

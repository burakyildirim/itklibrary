<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'BURAK YILDIRIM',
                'role' => '1',
                'email' => 'burak.yildirim@itk.k12.tr',
                'password' => '$2y$10$AazkMbgE18oX03.gNDpOEesCtC0A00VYOUi2Os9hQTrWmJsZsVQAe'
            ],
            [
                'name' => 'JOKER KÜTÜPHANE YÖNETİCİSİ',
                'role' => '3',
                'email' => 'kutuphane@itk.k12.tr',
                'password' => '$2y$10$AazkMbgE18oX03.gNDpOEesCtC0A00VYOUi2Os9hQTrWmJsZsVQAe'
            ]
        ]);
    }
}

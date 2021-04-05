<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibrariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('libraries')->insert([
            [
                'libraries_name' => 'Bahattin Tatış Kampüs Kütüphanesi',
                'libraries_phone' => '0 232 244 0 500',
                'libraries_address' => 'btk adres',
                'libraries_img' => '',
                'libraries_auth' => 2
            ],
            [
                'libraries_name' => 'Bornova Kampüs Kütüphanesi',
                'libraries_phone' => '0 232 216 24 85',
                'libraries_address' => 'bornova adres',
                'libraries_img' => '',
                'libraries_auth' => 2
            ],
            [
                'libraries_name' => 'Büyükçiğli Kampüs Kütüphanesi',
                'libraries_phone' => '0 232 386 57 27',
                'libraries_address' => 'çiğli adres',
                'libraries_img' => '',
                'libraries_auth' => 2
            ],
            [
                'libraries_name' => 'Marmaris Kampüs Kütüphanesi',
                'libraries_phone' => '0 252 419 19 19',
                'libraries_address' => 'marmaris kampüs adres',
                'libraries_img' => '',
                'libraries_auth' => 2
            ],
            [
                'libraries_name' => 'Manisa Kampüs Kütüphanesi',
                'libraries_phone' => '0 236 250 50 70',
                'libraries_address' => 'manisa kampüs adres',
                'libraries_img' => '',
                'libraries_auth' => 2
            ],
        ]);
    }
}

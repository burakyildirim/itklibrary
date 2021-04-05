<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'settings_description' => 'Başlık',
                'settings_key' => 'title',
                'settings_value' => 'TheThanksForToday',
                'settings_type' => 'text',
                'settings_order' => 0,
                'settings_delete' => '0',
                'settings_status' => '1'
            ],
            [
                'settings_description' => 'Açıklama',
                'settings_key' => 'description',
                'settings_value' => 'Gratefulness for Today',
                'settings_type' => 'text',
                'settings_order' => 1,
                'settings_delete' => '0',
                'settings_status' => '1'
            ],
            [
                'settings_description' => 'Logo',
                'settings_key' => 'logo',
                'settings_value' => 'logo.png',
                'settings_type' => 'file',
                'settings_order' => 2,
                'settings_delete' => '0',
                'settings_status' => '1'
            ],
            [
                'settings_description' => 'Icon',
                'settings_key' => 'icon',
                'settings_value' => 'icon.ico',
                'settings_type' => 'file',
                'settings_order' => 3,
                'settings_delete' => '0',
                'settings_status' => '1'
            ],
            [
                'settings_description' => 'Anahtar Kelimeler',
                'settings_key' => 'keywords',
                'settings_value' => 'thethanksfortoday',
                'settings_type' => 'text',
                'settings_order' => 4,
                'settings_delete' => '0',
                'settings_status' => '1'
            ],
            [
                'settings_description' => 'Telefon Sabit',
                'settings_key' => 'phone',
                'settings_value' => '0850 000 00 00',
                'settings_type' => 'text',
                'settings_order' => 5,
                'settings_delete' => '0',
                'settings_status' => '1'
            ],
            [
                'settings_description' => 'Telefon GSM',
                'settings_key' => 'phone_gsm',
                'settings_value' => '0530 677 74 12',
                'settings_type' => 'text',
                'settings_order' => 6,
                'settings_delete' => '0',
                'settings_status' => '1'
            ],
            [
                'settings_description' => 'İletişim Mail',
                'settings_key' => 'contact_mail',
                'settings_value' => 'thanks@thethanksfortoday.com',
                'settings_type' => 'text',
                'settings_order' => 7,
                'settings_delete' => '0',
                'settings_status' => '1'
            ],
            [
                'settings_description' => 'Tam Adres',
                'settings_key' => 'address',
                'settings_value' => 'Izmir/TURKEY',
                'settings_type' => 'text',
                'settings_order' => 8,
                'settings_delete' => '0',
                'settings_status' => '1'
            ],
            [
                'settings_description' => 'Silme Denemesi için',
                'settings_key' => 'silmedeneme',
                'settings_value' => 'silebilirsiniz',
                'settings_type' => 'text',
                'settings_order' => 9,
                'settings_delete' => '1',
                'settings_status' => '1'
            ],
            [
                'settings_description' => 'Silme Denemesi için 2',
                'settings_key' => 'silmedeneme2',
                'settings_value' => 'silebilirsiniz 2',
                'settings_type' => 'ckeditor',
                'settings_order' => 10,
                'settings_delete' => '1',
                'settings_status' => '1'
            ]
        ]);
    }
}

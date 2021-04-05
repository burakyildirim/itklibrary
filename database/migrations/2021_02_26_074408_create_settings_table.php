<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * type: bu alan bir ckeditor alanı mı textbox mı, checkbox mı
         * delete: silinebilir bir ayar mı
         * status: aktif pasif
         * order: sıra numarası
         * key: ayar daha sonra hangi isimle çağırılacak
         * description: ayar açıklaması
         * value: ayarın değeri
         */
        Schema::create('settings', function (Blueprint $table) {
            $table->collation = 'utf8_turkish_ci';
            $table->id();
            $table->timestamps();
            $table->string('settings_description');
            $table->text('settings_value');
            $table->string('settings_key');
            $table->string('settings_type');
            $table->string('settings_order');
            $table->enum('settings_delete',['0','1']);
            $table->enum('settings_status',['0','1']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}

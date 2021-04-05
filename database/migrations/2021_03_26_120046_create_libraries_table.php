<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->collation = 'utf8_turkish_ci';
            $table->id();
            $table->timestamps();
            $table->string('libraries_name');
            $table->text('libraries_phone')->nullable();
            $table->text('libraries_address')->nullable();
            $table->text('libraries_img')->nullable();
            $table->integer('libraries_auth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libraries');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelDigitalBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_digital_book', function (Blueprint $table) {
            $table->integer('level_id');
//            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');

            $table->integer('digital_book_id');
//            $table->foreign('digital_book_id')->references('id')->on('digital_books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('level_digital_book');
    }
}

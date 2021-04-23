<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('unique_key');
            $table->string('ebooks_name');
            $table->string('ebooks_slug');
            $table->text('ebooks_description');
            $table->text('ebooks_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_books');
    }
}

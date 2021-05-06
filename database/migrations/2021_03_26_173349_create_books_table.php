<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->collation = 'utf8_turkish_ci';
            $table->id();
            $table->timestamps();
            $table->text('book_name');
            $table->text('book_author');
            $table->string('book_image')->nullable();
            $table->text('book_publisher')->nullable();
            $table->date('book_publishDate')->nullable();
            $table->text('book_description')->nullable();
            $table->integer('book_rentStatus')->default('1');
            $table->integer('book_visStatus')->default('1');
            $table->integer('book_language');
            $table->integer('libraries_id');
            $table->integer('book_stok')->default('1');
            $table->text('book_slug');
            $table->string('book_isbn');
            $table->string('book_raf')->default('A');
            $table->string('book_sira')->default('1');
            $table->integer('book_createdBy');
            $table->integer('book_updatedBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}

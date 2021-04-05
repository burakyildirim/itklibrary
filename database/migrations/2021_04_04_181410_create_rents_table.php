<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->collation = 'utf8_turkish_ci';
            $table->id();
            $table->timestamps();

            $table->integer('books_id');
            $table->integer('users_id');

            $table->integer('rent_auth');

            $table->dateTime('rentStartDate');
            $table->dateTime('rentEndDate');

            $table->integer('rent_status')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rents');
    }
}

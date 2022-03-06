<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookConnectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('book_connects');
        Schema::create('book_connects', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('books');
            $table->integer('user_to');
            $table->foreign('user_to')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_connects');
    }
}

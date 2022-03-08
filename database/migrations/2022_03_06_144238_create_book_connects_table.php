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
        Schema::dropIfExists('library_connects');
        Schema::create('library_connects', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('library_id');
            $table->foreign('library_id')->references('id')->on('users');
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
        Schema::dropIfExists('library_connects');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tries', function (Blueprint $table) {
            $table->increments('TID');
            $table->integer('PID')->unsigned();
            $table->integer('QID')->unsigned();
            $table->integer('answer');
            $table->integer('try_no');
            $table->timestamps();

            $table->foreign('PID')->references('PID')->on('users');
            $table->foreign('QID')->references('QID')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tries');

        $table->foreign('PID')
              ->references('PID')->on('users')
              ->onDelete('cascade');

       $table->foreign('QID')
             ->references('QID')->on('questions')
             ->onDelete('cascade');
    }
}

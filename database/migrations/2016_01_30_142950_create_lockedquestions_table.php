<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLockedquestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lockedquestions', function (Blueprint $table) {
            $table->increments('LID');
            $table->integer('PID')->unsigned();           
            $table->integer('QID')->unsigned();
            $table->integer('day');
            $table->integer('try_count')->default(3);
            $table->integer('successful')->unsigned()->default(NULL);
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
        Schema::drop('lockedquestions');

        $table->foreign('PID')
              ->references('PID')->on('users')
              ->onDelete('cascade');

        $table->foreign('QID')
              ->references('QID')->on('questions')
              ->onDelete('cascade'); 
        
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus', function (Blueprint $table) {
            $table->increments('BID');
            $table->string('question');
            $table->integer('ans1');
            $table->integer('ans2');
            $table->integer('ans3');
            $table->integer('ans4');
			$table->integer('ans5');
			$table->integer('ans6');
			$table->integer('sum');
			$table->integer('day')->unsigned();
			$table->integer('qpos')->unsigned()->default(7);
			
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
        Schema::drop('bonus');

        
    }
}

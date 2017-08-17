<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Choice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('choicetbl', function(Blueprint $table) {
            $table->increments('choiceid');
            $table->integer('questionid')->unsigned();
            $table->text('answer');
            $table->boolean('iscorrect');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('questionid')->references('questionid')->on('questiontbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('choicetbl');
    }
}

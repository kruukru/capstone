<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Testquestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testquestiontbl', function(Blueprint $table) {
            $table->increments('testquestionid');
            $table->integer('testid')->unsigned();
            $table->integer('questionid')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('testid')->references('testid')->on('testtbl');
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
        Schema::drop('testquestiontbl');
    }
}

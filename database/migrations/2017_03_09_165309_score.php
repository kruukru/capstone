<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Score extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scoretbl', function(Blueprint $table) {
            $table->increments('scoreid');
            $table->integer('applicantid')->unsigned();
            $table->integer('testid')->unsigned();
            $table->integer('score')->unsigned();
            $table->integer('item')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('applicantid')->references('applicantid')->on('applicanttbl');
            $table->foreign('testid')->references('testid')->on('testtbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scoretbl');
    }
}

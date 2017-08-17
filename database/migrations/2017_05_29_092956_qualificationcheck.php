<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Qualificationcheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualificationchecktbl', function(Blueprint $table) {
            $table->increments('qualificationcheckid');
            $table->integer('deployid')->unsigned();
            $table->integer('applicantid')->unsigned();
            $table->tinyInteger('status');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('deployid')->references('deployid')->on('deploytbl');
            $table->foreign('applicantid')->references('applicantid')->on('applicanttbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('qualificationchecktbl');
    }
}

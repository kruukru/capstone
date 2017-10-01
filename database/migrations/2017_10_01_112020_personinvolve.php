<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Personinvolve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personinvolvetbl', function(Blueprint $table) {
            $table->increments('personinvolveid');
            $table->integer('reportid')->unsigned();
            $table->integer('applicantid')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('reportid')->references('reportid')->on('reporttbl');
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
        Schema::drop('personinvolvetbl');
    }
}

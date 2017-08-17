<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Applicantrequirement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicantrequirementtbl', function(Blueprint $table) {
            $table->increments('applicantrequirementid');
            $table->integer('applicantid')->unsigned();
            $table->integer('requirementid')->unsigned();
            $table->boolean('issubmitted');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('applicantid')->references('applicantid')->on('applicanttbl');
            $table->foreign('requirementid')->references('requirementid')->on('requirementtbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('applicantrequirementtbl');
    }
}

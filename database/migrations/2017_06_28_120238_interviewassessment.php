<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Interviewassessment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviewassessmenttbl', function(Blueprint $table) {
            $table->increments('interviewassessmentid');
            $table->integer('applicantid')->unsigned();
            $table->integer('adminid')->unsigned();
            $table->integer('assessmenttopicid')->unsigned();
            $table->text('message');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('applicantid')->references('applicantid')->on('applicanttbl');
            $table->foreign('adminid')->references('adminid')->on('admintbl');
            $table->foreign('assessmenttopicid')->references('assessmenttopicid')->on('assessmenttopictbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('interviewassessmenttbl');
    }
}

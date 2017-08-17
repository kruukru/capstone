<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Testassessment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testassessmenttbl', function(Blueprint $table) {
            $table->increments('testassessmentid');
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
        Schema::drop('testassessmenttbl');
    }
}

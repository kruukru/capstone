<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Attendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendancetbl', function(Blueprint $table) {
            $table->increments('attendanceid');
            $table->integer('deploymentsiteid')->unsigned();
            $table->integer('applicantid')->unsigned();
            $table->date('date');
            $table->time('timein')->nullable();
            $table->time('timeout')->nullable();
            $table->text('reason')->nullable();
            $table->tinyInteger('status');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('deploymentsiteid')->references('deploymentsiteid')->on('deploymentsitetbl');
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
        Schema::drop('attendancetbl');
    }
}

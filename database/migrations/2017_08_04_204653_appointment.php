<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Appointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointmenttbl', function(Blueprint $table) {
            $table->increments('appointmentid');
            $table->integer('applicantid')->unsigned();
            $table->integer('appointmentdateid')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('applicantid')->references('applicantid')->on('applicanttbl');
            $table->foreign('appointmentdateid')->references('appointmentdateid')->on('appointmentdatetbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('appointmenttbl');
    }
}

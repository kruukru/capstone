<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Appointmentdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointmentdatetbl', function(Blueprint $table) {
            $table->increments('appointmentdateid');
            $table->integer('holidayid')->unsigned()->nullable();
            $table->date('date');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('holidayid')->references('holidayid')->on('holidaytbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('appointmentdatetbl');
    }
}

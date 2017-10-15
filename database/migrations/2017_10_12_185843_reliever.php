<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reliever extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relievertbl', function(Blueprint $table) {
            $table->increments('relieverid');
            $table->integer('deploymentsiteid')->unsigned();
            $table->integer('applicantid')->unsigned();
            $table->string('type');
            $table->date('date');
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
        Schema::drop('relievertbl');
    }
}

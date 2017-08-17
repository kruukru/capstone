<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Educationbackground extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educationbackgroundtbl', function(Blueprint $table) {
            $table->increments('educationbackgroundid');
            $table->integer('applicantid')->unsigned();
            $table->string('graduatetype');
            $table->string('degree')->nullable();
            $table->date('dategraduated');
            $table->string('schoolgraduated');

            $table->timestamps();
            $table->softDeletes();

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
        Schema::drop('educationbackgroundtbl');
    }
}

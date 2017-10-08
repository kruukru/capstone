<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Replaceapplicant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replaceapplicanttbl', function(Blueprint $table) {
            $table->increments('replaceapplicantid');
            $table->integer('qualificationcheckid')->unsigned();
            $table->integer('accountid')->unsigned();
            $table->text('reason');
            $table->tinyInteger('status');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('qualificationcheckid')->references('qualificationcheckid')->on('qualificationchecktbl');
            $table->foreign('accountid')->references('accountid')->on('accounttbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('replaceapplicanttbl');
    }
}

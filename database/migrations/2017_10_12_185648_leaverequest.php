<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Leaverequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaverequesttbl', function(Blueprint $table) {
            $table->increments('leaverequestid');
            $table->integer('requestid')->unsigned();
            $table->integer('applicantid')->unsigned();
            $table->date('start');
            $table->date('end');
            $table->text('reason');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('requestid')->references('requestid')->on('requesttbl');
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
        Schema::drop('leaverequesttbl');
    }
}

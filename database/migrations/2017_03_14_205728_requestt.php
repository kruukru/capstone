<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Requestt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requesttbl', function(Blueprint $table) {
            $table->increments('requestid');
            $table->integer('deploymentsiteid')->unsigned();
            $table->integer('accountid')->unsigned();
            $table->string('type');
            $table->date('datecreated');
            $table->tinyInteger('status');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('deploymentsiteid')->references('deploymentsiteid')->on('deploymentsitetbl');
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
        Schema::drop('requesttbl');
    }
}

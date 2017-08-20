<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Managersite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managersitetbl', function(Blueprint $table) {
            $table->increments('managersiteid');
            $table->integer('managerid')->unsigned();
            $table->integer('deploymentsiteid')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('managerid')->references('managerid')->on('managertbl');
            $table->foreign('deploymentsiteid')->references('deploymentsiteid')->on('deploymentsitetbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('managersitetbl');
    }
}

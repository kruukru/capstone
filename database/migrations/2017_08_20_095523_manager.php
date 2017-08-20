<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Manager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managertbl', function(Blueprint $table) {
            $table->increments('managerid');
            $table->integer('clientid')->unsigned();
            $table->integer('accountid')->unsigned();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('clientid')->references('clientid')->on('clienttbl');
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
        Schema::drop('managertbl');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Deploymentsite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deploymentsitetbl', function(Blueprint $table) {
            $table->increments('deploymentsiteid');
            $table->integer('contractid')->unsigned();
            $table->string('sitename');
            $table->string('location');
            $table->string('city');
            $table->string('province');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->tinyInteger('status');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('contractid')->references('contractid')->on('contracttbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deploymentsitetbl');
    }
}

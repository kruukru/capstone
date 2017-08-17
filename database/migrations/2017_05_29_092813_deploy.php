<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Deploy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deploytbl', function(Blueprint $table) {
            $table->increments('deployid');
            $table->integer('deploymentsiteid')->unsigned();
            $table->date('dateissued');
            $table->date('expiration');
            $table->tinyInteger('status');

            $table->timestamps();
            $table->softDeletes();

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
        Schema::drop('deploytbl');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Relieverabsent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relieverabsenttbl', function(Blueprint $table) {
            $table->increments('relieverabsentid');
            $table->integer('relieverid')->unsigned();
            $table->integer('attendanceid')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('relieverid')->references('relieverid')->on('relievertbl');
            $table->foreign('attendanceid')->references('attendanceid')->on('attendancetbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('relieveabsenttbl');
    }
}

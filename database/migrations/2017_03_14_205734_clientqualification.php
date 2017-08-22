<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Clientqualification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientqualificationtbl', function(Blueprint $table) {
            $table->increments('clientqualificationid');
            $table->integer('deploymentsiteid')->unsigned();
            $table->integer('requestid')->unsigned()->nullable();
            $table->integer('requireno');
            $table->string('gender');
            $table->string('attainment');
            $table->string('civilstatus');
            $table->string('age');
            $table->string('height');
            $table->string('weight');
            $table->double('workexp')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('deploymentsiteid')->references('deploymentsiteid')->on('deploymentsitetbl');
            $table->foreign('requestid')->references('requestid')->on('requesttbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clientqualificationtbl');
    }
}

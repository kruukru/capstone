<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Relieverleave extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relieverleavetbl', function(Blueprint $table) {
            $table->increments('relieverleaveid');
            $table->integer('relieverid')->unsigned();
            $table->integer('leaverequestid')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('relieverid')->references('relieverid')->on('relievertbl');
            $table->foreign('leaverequestid')->references('leaverequestid')->on('leaverequesttbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('relieveleavetbl');
    }
}

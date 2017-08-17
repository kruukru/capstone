<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Issuedfirearm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issuedfirearmtbl', function(Blueprint $table) {
            $table->increments('issuedfirearmid');
            $table->integer('issueditemid')->unsigned();
            $table->integer('firearmid')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('issueditemid')->references('issueditemid')->on('issueditemtbl');
            $table->foreign('firearmid')->references('firearmid')->on('firearmtbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('issuedfirearmtbl');
    }
}

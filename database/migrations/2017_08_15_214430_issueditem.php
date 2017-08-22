<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Issueditem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issueditemtbl', function(Blueprint $table) {
            $table->increments('issueditemid');
            $table->integer('deploymentsiteid')->unsigned();
            $table->integer('deployid')->unsigned();
            $table->integer('itemid')->unsigned();
            $table->integer('qty');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('deploymentsiteid')->references('deploymentsiteid')->on('deploymentsitetbl');
            $table->foreign('deployid')->references('deployid')->on('deploytbl');
            $table->foreign('itemid')->references('itemid')->on('itemtbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('issueditemtbl');
    }
}

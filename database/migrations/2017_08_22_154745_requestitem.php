<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Requestitem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requestitemtbl', function(Blueprint $table) {
            $table->increments('requestitemid');
            $table->integer('requestid')->unsigned();
            $table->integer('itemid')->unsigned();
            $table->integer('qty');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('requestid')->references('requestid')->on('requesttbl');
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
        Schema::drop('requestitemtbl');
    }
}

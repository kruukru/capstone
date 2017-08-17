<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Firearm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firearmtbl', function(Blueprint $table) {
            $table->increments('firearmid');
            $table->integer('itemid')->unsigned();
            $table->string('license');
            $table->date('expiration');

            $table->timestamps();
            $table->softDeletes();

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
        Schema::drop('firearmtbl');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Contract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracttbl', function(Blueprint $table) {
            $table->increments('contractid');
            $table->integer('clientid')->unsigned();
            $table->integer('adminid')->unsigned();
            $table->integer('areatypeid')->unsigned();
            $table->integer('parentcontractid')->unsigned()->nullable();
            $table->date('startdate');
            $table->date('expiration');
            $table->string('placesigned');
            $table->string('price');
            $table->tinyInteger('status');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('clientid')->references('clientid')->on('clienttbl');
            $table->foreign('adminid')->references('adminid')->on('admintbl');
            $table->foreign('areatypeid')->references('areatypeid')->on('areatypetbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contracttbl');
    }
}

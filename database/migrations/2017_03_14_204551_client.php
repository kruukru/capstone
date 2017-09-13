<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Client extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clienttbl', function(Blueprint $table) {
            $table->increments('clientid');
            $table->integer('accountid')->unsigned();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('position');
            $table->string('contactpersonno');
            $table->string('company');
            $table->string('address');
            $table->string('companycontactno');
            $table->string('email');
            $table->tinyInteger('status');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('accountid')->references('accountid')->on('accounttbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clienttbl');
    }
}

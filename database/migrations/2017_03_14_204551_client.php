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
            $table->string('name', 100);
            $table->string('address');
            $table->string('contactno', 20);
            $table->string('contactperson', 150);
            $table->string('contactpersonno', 20);
            $table->string('email', 100);

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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Account extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounttbl', function(Blueprint $table) {
            $table->increments('accountid');
            $table->string('username');
            $table->string('password');
            $table->tinyInteger('accounttype');
            $table->string('remember_token')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accounttbl');
    }
}

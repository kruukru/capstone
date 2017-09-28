<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Company extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companytbl', function(Blueprint $table) {
            $table->increments('companyid');
            $table->string('name', 100);
            $table->string('shortname', 9);
            $table->text('address');
            $table->text('contactno');
            $table->text('logo');

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
        Schema::drop('companytbl');
    }
}

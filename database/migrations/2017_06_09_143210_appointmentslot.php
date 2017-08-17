<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Appointmentslot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointmentslottbl', function(Blueprint $table) {
            $table->increments('appointmentslotid');
            $table->boolean('sunday');
            $table->boolean('monday');
            $table->boolean('tuesday');
            $table->boolean('wednesday');
            $table->boolean('thursday');
            $table->boolean('friday');
            $table->boolean('saturday');
            $table->integer('slot');
            $table->integer('noofday');

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
        Schema::drop('appointmentslotstbl');
    }
}

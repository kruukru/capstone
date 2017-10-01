<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Report extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporttbl', function(Blueprint $table) {
            $table->increments('reportid');
            $table->integer('accountid')->unsigned();
            $table->integer('commendid')->unsigned()->nullable();
            $table->integer('violationid')->unsigned()->nullable();
            $table->string('placehappen', 100);
            $table->string('subject', 100);
            $table->text('detail');
            $table->date('date');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('accountid')->references('accountid')->on('accounttbl');
            $table->foreign('commendid')->references('commendid')->on('commendtbl');
            $table->foreign('violationid')->references('violationid')->on('violationtbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reporttbl');
    }
}

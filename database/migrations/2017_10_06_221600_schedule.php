<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Schedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduletbl', function(Blueprint $table) {
            $table->increments('scheduleid');
            $table->integer('applicantid')->unsigned();
            $table->boolean('sunday');
            $table->time('sundayin')->nullable();
            $table->time('sundayout')->nullable();
            $table->boolean('monday');
            $table->time('mondayin')->nullable();
            $table->time('mondayout')->nullable();
            $table->boolean('tuesday');
            $table->time('tuesdayin')->nullable();
            $table->time('tuesdayout')->nullable();
            $table->boolean('wednesday');
            $table->time('wednesdayin')->nullable();
            $table->time('wednesdayout')->nullable();
            $table->boolean('thursday');
            $table->time('thursdayin')->nullable();
            $table->time('thursdayout')->nullable();
            $table->boolean('friday');
            $table->time('fridayin')->nullable();
            $table->time('fridayout')->nullable();
            $table->boolean('saturday');
            $table->time('saturdayin')->nullable();
            $table->time('saturdayout')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('applicantid')->references('applicantid')->on('applicanttbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scheduletbl');
    }
}

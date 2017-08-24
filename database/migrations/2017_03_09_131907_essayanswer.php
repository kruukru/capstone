<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Essayanswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('essayanswertbl', function(Blueprint $table) {
            $table->increments('essayanswerid');
            $table->integer('applicantid')->unsigned();
            $table->integer('testquestionid')->unsigned();
            $table->text('answer')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('applicantid')->references('applicantid')->on('applicanttbl');
            $table->foreign('testquestionid')->references('testquestionid')->on('testquestiontbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('essayanswertbl');
    }
}

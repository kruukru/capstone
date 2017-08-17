<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Questionanswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionanswertbl', function(Blueprint $table) {
            $table->increments('questionanswerid');
            $table->integer('applicantid')->unsigned();
            $table->integer('testquestionid')->unsigned();
            $table->text('answer');
            $table->boolean('iscorrect')->nullable();

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
        Schema::drop('questionanswertbl');
    }
}

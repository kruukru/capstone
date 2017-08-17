<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Employmentrecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employmentrecordtbl', function(Blueprint $table) {
            $table->increments('employmentrecordid');
            $table->integer('applicantid')->unsigned();
            $table->string('company', 100);
            $table->string('industrytype')->nullable();
            $table->double('duration');
            $table->text('reason')->nullable();

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
        Schema::drop('employmentrecordtbl');
    }
}

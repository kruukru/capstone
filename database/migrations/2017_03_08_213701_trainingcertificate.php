<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Trainingcertificate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainingcertificatetbl', function(Blueprint $table) {
            $table->increments('trainingcertificateid');
            $table->integer('applicantid')->unsigned();
            $table->string('certificate', 100);
            $table->string('conductedby', 150);
            $table->date('dateconducted')->nullable();

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
        Schema::drop('trainingcertificatetbl');
    }
}

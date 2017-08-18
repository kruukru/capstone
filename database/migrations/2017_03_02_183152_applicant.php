<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Applicant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicanttbl', function(Blueprint $table) {
            $table->increments('applicantid');
            $table->integer('accountid')->unsigned();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('suffix')->nullable();
            $table->string('cityaddress');
            $table->string('cityaddresscity');
            $table->string('cityaddressprovince');
            $table->string('provincialaddress')->nullable();
            $table->string('provincialaddresscity')->nullable();
            $table->string('provincialaddressprovince')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('gender');
            $table->text('picture');
            $table->date('dateofbirth');
            $table->string('placeofbirth');
            $table->tinyInteger('age');
            $table->string('civilstatus');
            $table->string('religion');
            $table->string('bloodtype');
            $table->string('appcontactno');
            $table->tinyInteger('workexp');
            $table->float('height');
            $table->float('weight');
            $table->string('license');
            $table->date('licenseexpiration');
            $table->string('sss');
            $table->string('philhealth');
            $table->string('pagibig');
            $table->string('tin');
            $table->text('hobby')->nullable();
            $table->text('skill')->nullable();
            $table->string('spousename')->nullable();
            $table->date('spousedateofbirth')->nullable();
            $table->string('spouseoccupation')->nullable();
            $table->string('contactperson');
            $table->string('contactno');
            $table->string('contacttelno')->nullable();
            $table->date('lastdeployed')->nullable();
            $table->tinyInteger('status');

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
        Schema::drop('applicanttbl');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Test extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testtbl', function(Blueprint $table) {
            $table->increments('testid');
            $table->string('name', 100);
            $table->text('instruction');
            $table->integer('maxquestion');
            $table->integer('timealloted');

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
        Schema::drop('testtbl');
    }
}

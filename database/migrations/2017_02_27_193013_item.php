<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Item extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemtbl', function(Blueprint $table) {
            $table->increments('itemid');
            $table->integer('itemtypeid')->unsigned();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->integer('qty')->unsigned();
            $table->integer('qtyavailable')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('itemtypeid')->references('itemtypeid')->on('itemtypetbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('itemtbl');
    }
}

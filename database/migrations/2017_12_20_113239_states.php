<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class States extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('name')->nullable();
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('states', function (BLueprint $table){

            $table->foreign('country_id')
                ->references('id')
                ->on('world_countries')->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('state_id')->unsigned();
            $table->string('name')->nullable();
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('cities', function (BLueprint $table){

            $table->foreign('state_id')
                ->references('id')
                ->on('states')->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}

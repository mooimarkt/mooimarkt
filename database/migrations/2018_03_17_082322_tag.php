<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('adsId')->unsigned();
            $table->string('type')->nullable();
            $table->string('tagValue')->nullable();
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('tag', function (BLueprint $table){

            $table->foreign('adsId')
                ->references('id')
                ->on('ads')->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}

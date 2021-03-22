<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsConditionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_condition', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ads_id')->unsigned();
            $table->integer('condition_id')->unsigned();

            $table->foreign('ads_id')->references('id')->on('ads');
            $table->foreign('condition_id')->references('id')->on('conditions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads_condition');
    }
}

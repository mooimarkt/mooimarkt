<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsFilterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_filter', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ads_id')->unsigned();
            $table->integer('filter_id')->unsigned();

            $table->foreign('ads_id')
                ->references('id')->on('ads')
                ->onDelete('cascade');
            $table->foreign('filter_id')
                ->references('id')->on('filters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads_filter');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PricingDataAndPricingAddonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        /*Schema::create('pricing_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('packageID')->unsigned();
            $table->string('type')->nullable();
            $table->string('data')->nullable();
            $table->timestamps();
        });*/
        Schema::table('pricing', function (Blueprint $table) {
            $table->dropColumn(['basic', 'autoBump', 'spotlight']);
            $table->string('type')->nullable();
            $table->integer('price')->unsigned();
            $table->string('data')->nullable();
        });
        /*Schema::create('pricing_add_ons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('packageID')->unsigned();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->integer('price')->unsigned();
            $table->string('data')->nullable();
            $table->timestamps();
        });*/

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

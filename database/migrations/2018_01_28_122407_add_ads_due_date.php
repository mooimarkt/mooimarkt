<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdsDueDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('ads', function (Blueprint $table) {
            $table->dateTime('dueDate')->nullable();
        });
        Schema::create('ads_promo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adsId')->unsigned();
            $table->string('promoType');
            $table->dateTime('promoDate')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        /*Schema::table('ads_promo', function (BLueprint $table){

            $table->foreign('adsId')
                ->references('id')
                ->on('ads')->softDeletes();

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

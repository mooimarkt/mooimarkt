<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_view', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adsId')->unsigned();
            $table->string('ipAddress');
            $table->string('viewAfter');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('ads_view', function (BLueprint $table){

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
        Schema::dropIfExists('ads_view');
    }
}

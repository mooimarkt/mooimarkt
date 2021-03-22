<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adsImages', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('adsId')->nullable()->unsigned();
            $table->string('imagePath');
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('adsImages', function (BLueprint $table){

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
        Schema::dropIfExists('adsImages');
    }
}

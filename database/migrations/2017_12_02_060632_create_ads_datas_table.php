<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_datas', function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer('adsId')->unsigned();
            $table->integer('formFieldId')->unsigned();
            $table->string('adsValue')->nullable();
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('ads_datas', function (BLueprint $table){

             $table->foreign('adsId')
                ->references('id')
                ->on('ads')->softDeletes();

            $table->foreign('formFieldId')
                ->references('id')
                ->on('form_fields')->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads_datas');
    }
}

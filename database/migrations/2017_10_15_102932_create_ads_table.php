<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('userId')->unsigned();
            $table->integer('subCategoryId')->unsigned();
            $table->string('adsName')->nullable();
            $table->string('adsType')->nullable();
            $table->string('adsPriceType')->nullable();
            $table->decimal('adsPrice', 8, 2)->nullable();
            $table->longText('adsDescription')->nullable();
            $table->string('adsCountry')->nullable();
            $table->string('adsRegion')->nullable();
            $table->string('adsCity')->nullable();
            $table->decimal('adsLongitude')->nullable();
            $table->decimal('adsLatitude')->nullable();
            $table->string('adsCallingCode')->nullable();
            $table->string('adsContactNo')->nullable();
            $table->string('adsImage')->nullable();
            $table->string('adsSelectedType')->nullable();
            $table->string('adsPlaceMethod')->nullable();
            $table->string('adsStatus')->nullable();
            $table->unsignedBigInteger('adsViews')->default(0);
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('ads', function (BLueprint $table){

            $table->foreign('userId')
                ->references('id')
                ->on('users')->softDeletes();

             $table->foreign('subCategoryId')
                ->references('id')
                ->on('sub_categories')->softDeletes();

        });
        DB::statement('ALTER TABLE ads ADD FULLTEXT full(adsName)');
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

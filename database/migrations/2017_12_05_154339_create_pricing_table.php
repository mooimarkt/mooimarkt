<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('subCategoryId')->unsigned();
            $table->integer('basic')->nullable();
            $table->integer('autoBump')->nullable();
            $table->string('spotlight')->nullable();
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('pricing', function (BLueprint $table){

             $table->foreign('subCategoryId')
                ->references('id')
                ->on('sub_categories')->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricing');
    }
}

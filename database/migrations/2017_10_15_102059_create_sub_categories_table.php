<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('categoryId')->unsigned();
            $table->string('subCategoryName')->nullable();
            $table->integer('sort')->nullable();
	        $table->integer('shrid');
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('sub_categories', function (BLueprint $table){

            $table->foreign('categoryId')
                ->references('id')
                ->on('categories')->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
}

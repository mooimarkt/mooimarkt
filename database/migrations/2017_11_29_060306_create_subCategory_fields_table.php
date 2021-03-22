<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoryFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subCategory_fields', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('subCategoryId')->unsigned();
            $table->integer('formFieldId')->unsigned();
            $table->tinyInteger('isShare')->nullable();
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('subCategory_fields', function (BLueprint $table){

            $table->foreign('subCategoryId')
                ->references('id')
                ->on('sub_categories')->softDeletes();

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
        Schema::dropIfExists('category_fields');
    }
}

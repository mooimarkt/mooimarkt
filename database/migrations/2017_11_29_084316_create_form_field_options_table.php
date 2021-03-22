<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFieldOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_field_options', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('formFieldId')->unsigned();
            $table->integer('parentFieldId')->nullable();
            $table->integer('sort')->nullable();
            $table->string('value')->nullable();
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('form_field_options', function (BLueprint $table){

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
        Schema::dropIfExists('form_field_options');
    }
}

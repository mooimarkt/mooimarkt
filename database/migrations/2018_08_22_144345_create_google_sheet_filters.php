<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoogleSheetFilters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('sheet_filters', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('subcategoryID');
		    $table->string('filed_name');
		    $table->string('place_type');
		    $table->string('filter_type');
		    $table->string('parentID');
		    $table->string('title');
		    $table->integer('sort');
		    $table->softDeletes();
		    $table->timestamps();
	    });
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

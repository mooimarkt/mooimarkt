<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_criteria', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId')->unsigned();
            $table->string('searchString')->nullable();
            $table->string('searchQuery')->nullable();
            $table->string('jsonData')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('search_criteria', function (BLueprint $table){

            $table->foreign('userId')
                ->references('id')
                ->on('users')->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_criteria');
    }
}

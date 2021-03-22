<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterTypeSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_type_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('filter_id')->unsigned();
            $table->integer('size_id')->unsigned();

            $table->foreign('filter_id')->references('id')->on('filters')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('filters')->onDelete('cascade');

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
        Schema::dropIfExists('filter_type_sizes');
    }
}

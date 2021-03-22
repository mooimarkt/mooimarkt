<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdsReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adsReport', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adsId')->unsigned();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('reason')->nullable();
            $table->string('comment')->nullable();
            $table->enum('status',"created",'in_progress','approved','rejected')->default('created');
            $table->string('type')->default('report');
            $table->boolean('important')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('adsReport', function (BLueprint $table){

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
        Schema::dropIfExists('adsReport');
    }
}

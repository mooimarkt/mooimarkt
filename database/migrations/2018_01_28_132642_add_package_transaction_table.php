<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackageTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('package_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adsId')->unsigned();
            $table->integer('packageId')->unsigned();
            $table->integer('price')->unsigned();
            $table->string('paymentCode')->nullable();
            $table->string('paymentChannel')->nullable();
            $table->string('paymentStatus')->nullable();
            $table->string('referenceId')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('package_transaction', function (BLueprint $table){

            $table->foreign('adsId')
                ->references('id')
                ->on('ads')->softDeletes();
            $table->foreign('packageId')
                ->references('id')
                ->on('pricing')->softDeletes();

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

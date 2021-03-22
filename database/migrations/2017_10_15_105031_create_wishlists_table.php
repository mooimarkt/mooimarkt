<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('wishlists', function (Blueprint $table) {

        //     $table->increments('id');
        //     $table->integer('userId')->unsigned();
        //     $table->integer('adsId')->unsigned();
        //     $table->string('wishlistStatus');
        //     $table->softDeletes();  
        //     $table->timestamps();
        // });

        // Schema::table('wishlists', function (BLueprint $table){

        //     $table->foreign('userId')
        //         ->references('id')
        //         ->on('users')->softDeletes();

        //      $table->foreign('adsId')
        //         ->references('id')
        //         ->on('ads')->softDeletes();

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('wishlists');
    }
}

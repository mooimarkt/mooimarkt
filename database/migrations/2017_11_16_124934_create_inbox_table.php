<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('currentUserId')->unsigned();
            $table->integer('senderUserId')->unsigned();
            $table->integer('adsId')->unsigned();
            $table->string('inboxStatus')->nullable();
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('inbox', function (BLueprint $table){

            $table->foreign('currentUserId')
                ->references('id')
                ->on('users')->softDeletes();

            $table->foreign('senderUserId')
                ->references('id')
                ->on('users')->softDeletes();

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
        Schema::dropIfExists('inbox');
    }
}

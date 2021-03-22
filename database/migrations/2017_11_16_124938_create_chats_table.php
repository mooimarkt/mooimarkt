<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('currentUserId')->unsigned();
            $table->integer('senderUserId')->unsigned();
            $table->integer('inboxId')->unsigned();
            $table->string('message');
            $table->string('isSender');
            $table->softDeletes();  
            $table->timestamps();
        });

        Schema::table('chats', function (BLueprint $table){

            $table->foreign('currentUserId')
                ->references('id')
                ->on('users')->softDeletes();

            $table->foreign('senderUserId')
                ->references('id')
                ->on('users')->softDeletes();

            $table->foreign('inboxId')
                ->references('id')
                ->on('inbox')->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}

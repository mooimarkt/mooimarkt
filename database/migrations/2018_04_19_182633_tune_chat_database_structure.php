<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TuneChatDatabaseStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('inbox', function($table)
        {
            $table->renameColumn('currentUserId', 'userID');
            $table->renameColumn('senderUserId', 'toID');
        });
        Schema::table('chats', function($table)
        {
            $table->renameColumn('currentUserId', 'userID');
            $table->renameColumn('senderUserId', 'senderID');
            $table->string('seen')->default("0");
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

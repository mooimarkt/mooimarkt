<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReservedUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function($table) {
            $table->dropColumn('is_reserved');

            $table->integer('reserved_user_id')->unsigned()->nullable();

            $table->foreign('reserved_user_id')
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
        //
    }
}

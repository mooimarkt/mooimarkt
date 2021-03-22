<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ads_id');
            $table->unsignedInteger('seller_id');
            $table->boolean('seller_confirmed')->nullable();
            $table->unsignedInteger('buyer_id');
            $table->boolean('buyer_confirmed')->nullable();
            $table->text('content')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->comment('success,waiting,cancel');
            $table->string('type')->comment('meeting,shipping');
            $table->dateTime('meeting')->nullable();
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
        Schema::dropIfExists('activities');
    }
}

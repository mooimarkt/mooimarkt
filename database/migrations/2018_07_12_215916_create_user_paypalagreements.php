<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaypalagreements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_agreements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->string('aid');
            $table->string('name');
            $table->enum('type',['recurring-plan','reference-tansacions'])->default('recurring-plan');
            $table->enum('status',['active','suspended','deleted','created','canceled','suspend-error','renew-error'])->default('created');
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
        Schema::dropIfExists('paypal_agreements');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DiscountVoucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('voucher', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voucherCode');
            $table->string('voucherName')->nullable();
            $table->decimal('discountValue', 5, 2);    
            $table->string('discountType')->comment('percentage,unit');
            $table->string('multipleRedeem'); 
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('voucher_redeem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId')->unsigned();
            $table->integer('voucherId')->unsigned();
            $table->string('transactionId');
            $table->string('status');
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
        //
    }
}

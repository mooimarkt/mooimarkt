<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMethodAndTransactionIdAndCurrencyAndTotalToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('adsId');
            $table->string('method')->after('userId')->nullable();
            $table->string('transaction_id')->after('method')->nullable();
            $table->string('currency')->after('transaction_id')->nullable();
            $table->float('total')->after('currency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('adsId')->after('userId')->nullable();
            $table->dropColumn('method');
            $table->dropColumn('transaction_id');
            $table->dropColumn('currency');
            $table->dropColumn('total');
        });
    }
}

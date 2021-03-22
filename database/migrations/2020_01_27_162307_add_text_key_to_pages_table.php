<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTextKeyToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('text_key')->nullable()->after('page');
            $table->integer('static')->nullable()->default(0)->after('status');
            $table->string('meta_title')->nullable()->after('status');
            $table->string('meta_description')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('text_key');
            $table->dropColumn('static');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });
    }
}

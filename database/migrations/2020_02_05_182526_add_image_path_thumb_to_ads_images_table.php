<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImagePathThumbToAdsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adsImages', function (Blueprint $table) {
            $table->string('imagePath_thumb')->after('imagePath')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adsImages', function (Blueprint $table) {
            $table->dropColumn('imagePath_thumb');
        });
    }
}

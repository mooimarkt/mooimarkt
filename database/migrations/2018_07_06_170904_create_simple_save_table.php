<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimpleSaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simple_save', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->boolean('notify');
            $table->json('search');/* {"s":"search string","tags":["tag1","tag2"],"category":1,"sub_category":2} */
	        $table->integer("cid")->virtualAs('search->>"$.category"');
	        $table->integer("sid")->virtualAs('search->>"$.sub_category"');
	        $table->string("s")->virtualAs('search->>"$.s"');
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
        Schema::dropIfExists('simple_save');
    }
}

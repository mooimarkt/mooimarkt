<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        
        Schema::create('users', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string ('region')->nullable();
            $table->string ('country')->nullable();
            $table->string('city')->nullable();
            $table->decimal('longitude')->nullable();
            $table->decimal('latitude')->nullable();
            $table->string('callingCode')->nullable();   
            $table->string('phone')->nullable();        
            $table->string('userType')->nullable();
            $table->string('phoneContactType')->nullable();
            $table->string('b4mxContactType')->nullable();
            $table->string('emailContactType')->nullable();
            $table->string('userRole')->nullable();
            $table->string('subscription')->nullable();
            $table->boolean('isRetailer')->nullable(false)->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

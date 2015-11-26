<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname', 255);
            $table->string('lastname', 255);
            $table->string('email')->unique();            
            $table->string('password', 60);
            $table->string('activation_code');
            $table->boolean('active')->default(0);
            $table->string('approval_code', 255);
            $table->boolean('approved');
            $table->dateTime('last_login')->default(null);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}

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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',15)->unique();
            $table->string('name',50);
            $table->integer('room_no');
            $table->integer('auth_user_id')->unsigned();
            $table->integer('hostel_id')->unsigned();
            $table->integer('phone_contact')->unique();
            $table->integer('whatsapp_contact')->unique();
            $table->string('email')->unique();
            $table->string('fcm_id');
            $table->timestamps();

            $table->foreign('auth_user_id')->references('id')->on('authorization_levels');
            $table->foreign('hostel_id')->references('id')->on('hostels');
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

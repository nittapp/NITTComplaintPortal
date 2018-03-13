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
            $table->string('name',50)->default('NA');
            $table->integer('room_no')->default(0);
            $table->integer('auth_user_id')->unsigned()->default(1);
            $table->integer('hostel_id')->unsigned()->default(1);
            $table->string('phone_contact',10)->default('NA');
            $table->string('whatsapp_contact',10)->default('NA');
            $table->string('email')->default('NA');
            $table->string('fcm_id')->default('NA');
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

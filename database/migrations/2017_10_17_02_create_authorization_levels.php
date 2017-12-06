<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationLevels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorization_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',50);
            $table->boolean('complaint_create_access');
            $table->boolean('complaint_edit_access');
            $table->boolean('complaint_delete_access');
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
        Schema::dropIfExists('authorization_levels');
    }
}

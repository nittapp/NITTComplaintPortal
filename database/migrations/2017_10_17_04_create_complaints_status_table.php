<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintsStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->text('message');
            $table->boolean('is_viewable')->default(false);
            $table->boolean('is_creatable')->default(false);
            $table->boolean('is_editable')->default(false);
            $table->boolean('is_deletable')->default(false);
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
        Schema::dropIfExists('complaints_status');
    }
}

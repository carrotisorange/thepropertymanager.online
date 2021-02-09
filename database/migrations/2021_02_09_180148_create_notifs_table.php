<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifs', function (Blueprint $table) {
            $table->bigIncrements('notif_id');
            $table->unsignedBigInteger('user_id_foreign')->nullable();
            $table->foreign('user_id_foreign')->references('id')->on('users');
            $table->string('message');
            $table->string('type');
            $table->uuid('property_id_foreign')->nullable();
            $table->foreign('property_id_foreign')->references('property_id')->on('properties');
            $table->integer('isOpen')->default(0);
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
        Schema::dropIfExists('notifs');
    }
}

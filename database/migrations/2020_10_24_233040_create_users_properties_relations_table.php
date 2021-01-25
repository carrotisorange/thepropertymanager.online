<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPropertiesRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_properties_relations', function (Blueprint $table) {
            $table->bigIncrements('user_property_id');

            $table->uuid('property_id_foreign');
            $table->foreign('property_id_foreign')->references('property_id')->on('properties')->onDelete('cascade');

            $table->unsignedBigInteger('user_id_foreign')->nullable();
            $table->foreign('user_id_foreign')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_properties_relations');
    }
}

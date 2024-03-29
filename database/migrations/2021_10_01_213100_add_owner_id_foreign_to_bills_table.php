<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOwnerIdForeignToBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
              $table->uuid('property_id_foreign')->nullable();
              $table->foreign('property_id_foreign')->references('property_id')->on('properties')->onDelete('cascade');
            $table->unsignedBigInteger('bill_owner_id')->nullable();
            $table->foreign('bill_owner_id')->references('owner_id')->on('owners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bills', function (Blueprint $table) {
            //
        });
    }
}

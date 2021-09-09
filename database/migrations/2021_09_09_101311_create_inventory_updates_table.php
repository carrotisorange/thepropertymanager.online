<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_updates', function (Blueprint $table) {
            $table->bigIncrements('inventory_update_id');
             $table->unsignedBigInteger('inventory_id_foreign')->nullable();
             $table->foreign('inventory_id_foreign')->references('inventory_id')->on('inventories')->onDelete('cascade');
            $table->integer('update_quantity');
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
        Schema::dropIfExists('inventory_updates');
    }
}

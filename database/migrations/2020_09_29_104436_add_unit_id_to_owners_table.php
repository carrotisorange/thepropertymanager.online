<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitIdToOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_owners', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id_foreign')->nullable();
            $table->foreign('unit_id_foreign')->references('unit_id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_owners', function (Blueprint $table) {
            //
        });
    }
}

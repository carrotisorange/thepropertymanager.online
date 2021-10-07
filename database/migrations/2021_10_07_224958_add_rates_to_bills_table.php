<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatesToBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->double('water_rate', 8,2)->nullable();
            $table->double('electricity_rate', 8, 2)->nullable();
            $table->double('curr_electricity_reading', 8,2)->nullable();
            $table->double('prev_electricity_reading', 8,2)->nullable();
            $table->double('curr_water_reading', 8, 2)->nullable();
            $table->double('prev_water_reading', 8,2)->nullable();
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

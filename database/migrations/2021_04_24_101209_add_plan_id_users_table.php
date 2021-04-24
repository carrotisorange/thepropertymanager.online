<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanIdUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id_foreign')->nullable();
            $table->foreign('plan_id_foreign')->references('id')->on('plans')->onDelete('cascade');
            $table->unsignedBigInteger('promo_code_id_foreign')->nullable();
            $table->foreign('promo_code_id_foreign')->references('promo_code_id')->on('promo_codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}

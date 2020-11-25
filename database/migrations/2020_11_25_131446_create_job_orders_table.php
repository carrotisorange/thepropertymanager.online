<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_orders', function (Blueprint $table) {
            $table->bigIncrements('joborder_id');
            $table->unsignedBigInteger('concern_id_foreign')->nullable();
            $table->foreign('concern_id_foreign')->references('concern_id')->on('concerns');
            $table->unsignedBigInteger('personnel_id_foreign')->nullable();
            $table->foreign('personnel_id_foreign')->references('personnel_id')->on('personnels');
            $table->string('status')->default('active');
            $table->string('summary');
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
        Schema::dropIfExists('job_orders');
    }
}

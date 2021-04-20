<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_bills', function (Blueprint $table) {
            $table->bigIncrements('property_bill_id');
            $table->unsignedBigInteger('particular_id_foreign');
            $table->foreign('particular_id_foreign')->references('particular_id')->on('particulars')->onDelete('cascade');
            $table->uuid('property_id_foreign');
            $table->foreign('property_id_foreign')->references('property_id')->on('properties')->onDelete('cascade');
            $table->integer('due_date')->nullable();
            $table->double('penalty', 8,2)->nullable();
            $table->double('rate', 8,2)->nullable();
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
        Schema::dropIfExists('property_bills');
    }
}

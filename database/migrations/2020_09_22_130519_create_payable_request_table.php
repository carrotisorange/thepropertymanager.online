<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayableRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payable_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no');
            $table->string('entry');
            $table->string('status');
            $table->double('amt', 8, 2);
            $table->string('property');
            $table->string('requested_by');
            $table->string('approved_by')->nullable();
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
        Schema::dropIfExists('payable_request');
    }
}

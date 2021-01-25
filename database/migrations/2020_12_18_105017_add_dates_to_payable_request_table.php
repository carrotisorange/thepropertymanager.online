<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatesToPayableRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payable_request', function (Blueprint $table) {
            $table->date('requested_at');
            $table->date('approved_at');
            $table->date('declined_at');
            $table->foreign('requester_id')->references('id')->on('users');
            $table->unsignedBigInteger('requester_id')->nullable();
            $table->foreign('approver_id')->references('id')->on('users');
            $table->unsignedBigInteger('approver_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payable_request', function (Blueprint $table) {
            //
        });
    }
}

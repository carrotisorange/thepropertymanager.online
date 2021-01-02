<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEntryIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payable_request', function (Blueprint $table) {
            $table->foreign('entry_id')->references('id')->on('payable_request');
            $table->unsignedBigInteger('entry_id')->nullable();
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

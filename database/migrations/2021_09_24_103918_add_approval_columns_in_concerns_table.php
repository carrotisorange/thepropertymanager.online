<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalColumnsInConcernsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concerns', function (Blueprint $table) {
            $table->date('approved_by_tenant_at')->nullable();
            $table->date('approved_by_owner_at')->nullable();
            $table->date('approved_by_manager_at')->nullable();
            $table->string('payee')->nullable();
            $table->string('payment_options')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('concerns', function (Blueprint $table) {
            //
        });
    }
}

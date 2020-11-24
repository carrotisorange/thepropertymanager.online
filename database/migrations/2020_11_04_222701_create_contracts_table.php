<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('contract_id')->primary();
            $table->unsignedBigInteger('unit_id_foreign')->nullable();
            $table->foreign('unit_id_foreign')->references('unit_id')->on('units')->onDelete('cascade');
            $table->unsignedBigInteger('tenant_id_foreign')->nullable();
            $table->foreign('tenant_id_foreign')->references('tenant_id')->on('tenants')->onDelete('cascade');
            $table->unsignedBigInteger('referrer_id_foreign')->nullable();
            $table->foreign('referrer_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->string('form_of_interaction');
            $table->float('rent', 10, 2);
            $table->string('status');
            $table->timestamp('movein_at');
            $table->timestamp('moveout_at');
            $table->float('initial_electric', 10, 2)->nullable();
            $table->float('initial_water', 10, 2)->nullable();
            $table->timestamp('terminated_at')->nullable();
            $table->timestamp('actual_moveout_at')->nullable();
            $table->string('moveout_reason')->nullable();
            $table->string('number_of_months');
            $table->float('discount', 10, 2);
            $table->string('term');
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
        Schema::dropIfExists('contracts');
    }
}

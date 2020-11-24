<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_owners', function (Blueprint $table) {
            $table->bigIncrements('unit_owner_id')->unsigned();
            $table->date('date_invested')->nullable();
            $table->string('unit_owner');
            $table->string('investor_email_address')->nullable();
            $table->string('investor_contact_no')->nullable();
            $table->string('investor_representative')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('investor_address')->nullable();
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            $table->float('investment_price', 8, 2)->nullable();
            $table->string('investment_type')->nullable();
            $table->float('discount', 8, 2)->nullable();
            $table->string('account_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_owners');
    }
}

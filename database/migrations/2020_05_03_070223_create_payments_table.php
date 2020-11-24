<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->unsignedBigInteger('payment_tenant_id');
            $table->date('payment_created');
            $table->double('amt_paid', 8, 2);
            $table->string('form_of_payment')->nullable();
            $table->string('or_number')->nullable();
            $table->string('ar_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('check_no')->nullable();
            $table->string('date_deposited')->nullable();
          

            $table->string('payment_note')->nullable();
            $table->timestamps();

            $table->foreign('payment_tenant_id')->references('tenant_id')
            ->on('tenants');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
         $table->dropForeign('payment_tenant_id');
    }
}

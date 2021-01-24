<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('billing_id')->unsigned();
            $table->unsignedBigInteger('bill_tenant_id');
            $table->date('date_posted');
            $table->string('particular');
            $table->double('amount', 8, 2);
            $table->string('billing_status')->default('unpaid');
            $table->string('details');
            $table->timestamps();
            $table->foreign('bill_tenant_id')->references('tenant_id')
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
        Schema::dropIfExists('billings');
        $table->dropForeign('bill_tenant_id');
    }
}

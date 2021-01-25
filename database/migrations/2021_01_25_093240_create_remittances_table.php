<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemittancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remittances', function (Blueprint $table) {
            $table->uuid('remittance_id')->primary();
            $table->unsignedBigInteger('unit_id_foreign')->nullable();
            $table->foreign('unit_id_foreign')->references('unit_id')->on('units')->onDelete('cascade');
            $table->unsignedBigInteger('payment_id_foreign')->nullable();
            $table->foreign('payment_id_foreign')->references('payment_id')->on('payments')->onDelete('cascade');
            $table->double('amt_remitted', 8, 2);
            $table->string('isRemitted');
            $table->string('particular');
            $table->date('dateRemitted');
            $table->date('start');
            $table->date('end');
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
        Schema::dropIfExists('remittances');
    }
}

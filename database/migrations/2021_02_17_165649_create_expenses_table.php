<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('expense_id')->primary();
            $table->unsignedBigInteger('unit_id_foreign')->nullable();
            $table->foreign('unit_id_foreign')->references('unit_id')->on('units')->onDelete('cascade');
            $table->uuid('remittance_id_foreign')->nullable();
            $table->foreign('remittance_id_foreign')->references('remittance_id')->on('remittances')->onDelete('cascade')->onUpdate('cascade');
            $table->double('expense_amt', 8, 2);
            $table->string('expense_particular')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}

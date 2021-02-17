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
            $table->unsignedBigInteger('unit_id_foreign');
            $table->foreign('unit_id_foreign')->references('unit_id')->on('units')->onDelete('cascade');
            $table->double('amt_remitted', 8, 2);
            $table->string('particular');
            $table->string('cv_number')->nullable();
            $table->string('check_number')->nullable();
            $table->string('prepared_by');
            $table->date('start_at');
            $table->date('end_at');
            $table->date('created_at');
            $table->date('remitted_at')->nullable();
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

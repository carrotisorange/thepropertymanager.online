<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->uuid('certificate_id')->primary();
            $table->unsignedBigInteger('unit_id_foreign')->nullable();
            $table->foreign('unit_id_foreign')->references('unit_id')->on('units')->onDelete('cascade');
            $table->unsignedBigInteger('owner_id_foreign')->nullable();
            $table->foreign('owner_id_foreign')->references('unit_owner_id')->on('unit_owners')->onDelete('cascade');
            $table->double('price', 8, 2)->nullable();
            $table->string('investment_type', 8, 2)->nullable();
            $table->timestamp('date_purchased')->nullable();
            $table->timestamp('date_accepted')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_type')->nullable();
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
        Schema::dropIfExists('certificates');
    }
}

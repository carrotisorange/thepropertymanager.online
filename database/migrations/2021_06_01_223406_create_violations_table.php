<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViolationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->bigIncrements('violation_id');
            $table->unsignedBigInteger('tenant_id_foreign')->nullable();
            $table->foreign('tenant_id_foreign')->references('tenant_id')->on('tenants')->onDelete('cascade');
            $table->enum('status', array('cancelled','received', 'pending', 'resolved'));
            $table->enum('frequency', array('warning','1st offence', '2nd offence', '3rd offence', 'nth offence'));
            $table->enum('severity', array('minor','major'));
            $table->longText('summary');
            $table->longText('sanction');
            $table->boolean('paid')->nullable();
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
        Schema::dropIfExists('violations');
    }
}

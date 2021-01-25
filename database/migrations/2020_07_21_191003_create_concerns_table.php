<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcernsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concerns', function (Blueprint $table) {
            $table->bigIncrements('concern_id');
            $table->unsignedBigInteger('concern_tenant_id');
            $table->unsignedBigInteger('concern_user_id');
            $table->string('category');
            $table->date('reported_at');
            $table->string('is_warranty');
            $table->string('urgency');

            $table->string('title');
            $table->string('concern_qty')->nullable();
            $table->longText('details');
            $table->string('status');
            $table->double('concern_amt', 8, 2)->nullable();
            $table->string('is_paid');
            $table->string('rating')->nullable();


            $table->timestamps();

            $table->foreign('concern_tenant_id')->references('tenant_id')
            ->on('tenants');

            $table->foreign('concern_user_id')->references('id')
            ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concerns');
    }
}

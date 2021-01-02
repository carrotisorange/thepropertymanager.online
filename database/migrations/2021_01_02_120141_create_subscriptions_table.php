<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->unsignedBigIntege
            r('plan_id');
            $table->date('starts_at');
            $table->date('ends_at');
            $table->string('status');
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
        Schema::dropIfExists('subscriptions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneNumberToConcernsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concerns', function (Blueprint $table) {
            $table->string('contact_no')->nullable();
            $table->string('concern_department');
            $table->string('is_warranty')->nullable();
            $table->date('scheduled_at')->nullable();
            $table->date('resolved_at')->nullable();
            $table->longText('action_taken')->nullable();
            $table->longText('remarks')->nullable();
            $table->unsignedBigInteger('resolved_by')->nullable();
            $table->foreign('resolved_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('concerns', function (Blueprint $table) {
            //
        });
    }
}

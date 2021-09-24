<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConcernAssessedByToConcernsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concerns', function (Blueprint $table) {
             $table->unsignedBigInteger('assessed_by_id')->nullable();
             $table->foreign('assessed_by_id')->references('personnel_id')->on('personnels')->onDelete('cascade');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScopeOfWorkToConcernsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concerns', function (Blueprint $table) {
            $table->longText('scope_of_work')->nullable();
            $table->date('ended_on')->nullable();
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

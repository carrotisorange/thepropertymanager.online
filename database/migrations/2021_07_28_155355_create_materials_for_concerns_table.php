<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsForConcernsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials_for_concerns', function (Blueprint $table) {
            $table->bigIncrements('material_id');
            $table->integer('quantity');
            $table->string('description');
            $table->double('price', 8, 2);
            $table->double('total_cost', 8, 2);
            $table->unsignedBigInteger('concern_id_foreign')->nullable();
            $table->foreign('concern_id_foreign')->references('concern_id')->on('concerns')->onDelete('cascade');
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
        Schema::dropIfExists('materials_for_concerns');
    }
}

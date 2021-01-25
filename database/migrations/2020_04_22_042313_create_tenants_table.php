<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->bigIncrements('tenant_id');
            $table->unsignedBigInteger('unit_tenant_id');
            $table->string('tenant_unique_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('birthdate')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('id_number')->nullable();

            //address
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();
            //contact no
            $table->string('contact_no');
            $table->string('email_address')->nullable();
            $table->float('tenant_monthly_rent', 10, 2);
            $table->string('gender')->nullable();

            $table->string('tenant_status');
            $table->date('movein_date')->nullable();
            $table->date('moveout_date')->nullable();
            $table->string('type_of_tenant');

            $table->string('guardian')->nullable();
            $table->string('guardian_relationship')->nullable();
            $table->string('guardian_contact_no')->nullable();

            //column for student tenant. 
            $table->string('high_school')->nullable();
            $table->string('high_school_address')->nullable();
            $table->string('college_school')->nullable();
            $table->string('college_school_address')->nullable();
            $table->string('course')->nullable();
            $table->string('year_level')->nullable();
     
            //column of working tenant.
            $table->string('employer')->nullable();
            $table->string('employer_address')->nullable();
            $table->string('job')->nullable();
            $table->string('years_of_employment')->nullable();
            $table->string('employer_contact_no')->nullable();

            $table->string('tenants_note')->nullable();
            $table->string('has_extended')->nullable();

            $table->date('actual_move_out_date')->nullable();
            $table->string('reason_for_moving_out')->nullable();

            $table->timestamps();

         

            $table->foreign('unit_tenant_id')->references('unit_id')
                ->on('units');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
        $table->dropForeign('unit_tenant_id');
    }
}

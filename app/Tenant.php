<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $primaryKey = 'tenant_id';
    
    protected $fillable =   [
                                'tenant_unique_id',
                                'first_name',
                                'middle_name',
                                'last_name',
                                'birthate',
                                'gender',
                                'civil_status',
                                'id_number',
                                'country',
                                'province',
                                'city',
                                'barangay',
                               
                                'contact_no',
                                 
                                'year_level', 
                                'type_of_tenant',
                                'high_school',
                                'high_school_address',
                                'college_school',
                                'college_school_address',
                                'course',
                                'employer',
                                'job',
                                'years_of_employment',
                                'employer_contact_no',
                                'zip_code',
                            ];


    public function contracts()
    {
        return $this->hasMany('App\Contract','tenant_id_foreign')->orderBy('contract_id', 'desc');
    }

    public function guardians()
    {
        return $this->hasMany('App\Guardian','tenant_id_foreign');
    }

    public function concerns()
    {
        return $this->hasMany('App\Concern', 'concern_tenant_id') ->orderBy('reported_at', 'desc')->orderBy('urgency', 'desc')->orderBy('status', 'desc');
    }

    public function payments(){
        return $this->hasMany('App\Payment','payment_tenant_id');
    }


    
}

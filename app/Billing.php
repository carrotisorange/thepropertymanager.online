<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $primaryKey = 'billing_id';

    protected $fillable = 
                        [
                            'billing_tenant_id',
                            'billing_date',
                            'billing_desc',
                            'billing_amt',
                            'details',
                            'billing_status',
                            'billing_no'
                        ];

 public function tenant()
    {
    return $this->belongsTo('App\Tenant', 'billing_tenant_id');
    }
}
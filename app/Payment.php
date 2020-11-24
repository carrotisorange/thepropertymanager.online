<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';

    protected $fillable = [
                            'payment_tenant_id',
                            'payment_created',
                            'amt_paid',
                            'form_of_payment',
                            'or_number',
                            'ar_number',
                            'bank_name',
                            'check_no',
                            'date_deposited',
            
                            'payment_status'
    ];

    public function tenant()
    {
        return $this->belongsTo('App\Tenant', 'billing_tenant_id');
    }
}

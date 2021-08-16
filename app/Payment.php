<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'payment_id';

    protected $fillable = [
                            'payment_tenant_id',
                            'payment_unit_id',
                            'payment_created',
                            'amt_paid',
                            'form',
                            'or_number',
                            'ar_number',
                            'bank_name',
                            'check_no',
                            'date_deposited',
                            'payment_status'
    ];

    public function tenant()
    {
        return $this->belongsTo('App\Tenant', 'bill_tenant_id');
    }
}

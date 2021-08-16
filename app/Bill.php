<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    use SoftDeletes;

    protected $table = 'bills';

    protected $primaryKey = 'bill_id';

    protected $fillable = 
                        [
                            'bill_id',
                            'bill_tenant_id',
                            'date_posted',
                            'start',
                            'end',
                            'billing_status',
                            'bill_no',
                            'particular_id_foreign',
                            'amount',
                            'batch_no',
                        ];

 public function tenant()
    {
    return $this->belongsTo('App\Tenant', 'bill_tenant_id');
    }

public function payments()
    {
    return $this->hasMany('App\Payment', 'payment_bill_id');
    }
}
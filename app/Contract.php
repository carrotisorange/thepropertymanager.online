<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';

    protected $primaryKey = 'contract_id';

    public $incrementing = false;

    protected $fillable = [
        'contract_id',
        'unit_id_foreign',
        'tenant_id_foreign',
        'form_of_interaction',
        'refferal_id_foreign',
        'movein_at',
        'moveout_at',
        'number_of_months',
        'discount',
        'term',
        'rent',
        'bill_batch_no'
];

    // public function unit()
    // {
    // return $this->belongsTo('App\Unit', 'unit_id');
    // }

    public function tenant()
    {
        return $this->belongsTo('App\Tenant', 'tenant_id_foreign');
    }

    public function room()
    {
        return $this->belongsTo(Unit::class);
    }
    

}

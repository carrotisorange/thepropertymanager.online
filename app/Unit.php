<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $primaryKey = 'unit_id';

    protected $fillable = [
                            'unit_id',
                            'unit_no',
                            'unit_unit_owner_id',
                            'floor_no',
                            'beds',
                            'monthly_rent',
                            'egr',
                            'status',
                            'type_of_units',
                            'discount',
                            'unit_property',
                            'building',
                           
    ];

    public function tenants()
    {
        return $this->hasMany('App\Tenant', 'unit_tenant_id');
    }

    public function owner()
    {
        return $this->belongsTo('App\UnitOwner', 'unit_id_foreign');
    }

    public function property()
    {
        return $this->belongsTo('App\Property');
    }

    public function contracts()
    {
        return $this->hasMany('App\Contract', 'unit_id_foreign');
    }

}

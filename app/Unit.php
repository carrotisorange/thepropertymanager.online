<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $primaryKey = 'unit_id';

    protected $fillable = [
                            'unit_id',
                            'unit_no',
                           'size',
                            'floor',
                            'rent',
                            'status',
                            'type',
                            'discount',
                            'property_id_foreign',
                            'unit_type_id_foreign',
                            'unit_floor_id_foreign',
                            'building',
    ];

    public function owner()
    {
        return $this->belongsTo('App\Owner', 'unit_id_foreign');
    }

    public function property()
    {
        return $this->belongsTo('App\Property');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function certificates()
    {
        return $this->hasMany('App\Certificate', 'unit_id_foreign');
    }

    public function remittances()
    {
        return $this->hasMany('App\Remittance', 'unit_id_foreign');
    }

    public function expenses()
    {
        return $this->hasMany('App\Expense', 'unit_id_foreign');
    }


}

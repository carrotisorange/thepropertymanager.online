<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $primaryKey = 'unit_id';

    protected $fillable = [
                            'unit_id',
                            'unit_no',
                           
                            'floor',
                            
                            'rent',
                            'egr',
                            'status',
                            'type',
                            'discount',
                            'property_id_foreign',
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
        return $this->hasMany('App\Contract', 'unit_id_foreign');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    protected $primaryKey = 'personnel_id';

    protected $fillable = [
                'personnel_name',
                'personnel_contact_no',
                'personnel_availability',
    ];

    public function tenant()
    {
        return $this->belongsTo('App\UnitOwner', 'unit_owner_id');
    }

    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}

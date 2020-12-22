<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';

    protected $primaryKey = 'contract_id';

    public $incrementing = false;

    public function unit()
    {
    return $this->belongsTo('App\Unit', 'unit_id');
    }

}

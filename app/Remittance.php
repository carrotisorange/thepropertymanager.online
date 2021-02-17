<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remittance extends Model
{
    protected $table = 'remittances';

    protected $primaryKey = 'remittance_id';

    public $incrementing = false;

    public function expenses()
    {
        return $this->hasMany('App\Expense', 'remittance_id_foreign');
    }


}

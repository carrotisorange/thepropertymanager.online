<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyBill extends Model
{
    protected $primaryKey = 'property_bill_id';

    protected $fillable = [
        'particular_id_foreign',
        'property_id_foreign',
        'due_date',
        'penalty',
        'rate'
    ];
}

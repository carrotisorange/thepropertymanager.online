<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
     use SoftDeletes;

    protected $table = 'inventories';

    protected $primaryKey = 'inventory_id';

    protected $fillable =
    [
    'inventory_id',
    'unit_id_foreign',
    'item',
    'quantity',
    'current_inventory',
    'remarks'
    ];

    public function unit()
    {
    return $this->belongsTo('App\Unit', 'unit_id_foreign');
    }
}

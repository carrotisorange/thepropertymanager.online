<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryUpdate extends Model
{
    protected $primaryKey = 'inventory_update_id';

    protected $fillable = [
        'inventory_id_foreign',
        'update_quantity'
    ];
}

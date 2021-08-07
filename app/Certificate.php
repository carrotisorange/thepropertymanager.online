<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'certificates';

    protected $primaryKey = 'certificate_id';

    public $incrementing = false;

    protected $fillable = [
        'certificate_id',
        'unit_id_foreign',
        'owner_id_foreign',
        'price',
        'investment_type',
        'date_purchased',
        'date_accepted',
        'status',
        'payment_type',
        'created_at',
        'updated_at'
     ];
}

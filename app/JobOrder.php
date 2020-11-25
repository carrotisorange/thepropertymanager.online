<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    protected $table = 'job_orders';

    protected $primaryKey = 'joborder_id';

    public $incrementing = false;
}

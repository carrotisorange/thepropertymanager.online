<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'certificates';

    protected $primaryKey = 'certificate_id';

    public $incrementing = false;
}

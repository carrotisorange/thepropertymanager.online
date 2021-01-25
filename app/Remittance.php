<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remittance extends Model
{
    protected $table = 'remittances';

    protected $primaryKey = 'remttaine_id';

    public $incrementing = false;

}

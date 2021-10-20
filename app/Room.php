<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $primaryKey = 'room_id';

      public function contracts()
      {
       return $this->hasMany('App\Contract', 'unit_id_foreign');
      }
}

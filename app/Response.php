<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{

    public function concern()
    {
    return $this->belongsTo('App\Concern');
    }
}

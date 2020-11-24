<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProperty extends Model
{
    
    protected $table = 'users_properties_relations';

    protected $primary_key = 'user_property_id';

    public function properties()
    {
        return $this->hasMany('App\Property');
    }

    public function users()
    {
        return $this->hasMany('App\User', 'user_id_foreign');
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $primaryKey = 'owner_id';

    protected $table = 'owners';

    protected $fillable = [
                            'name',
                            'email',
                            'mobile',
                            'representative',
                            'acccount_number',
                            'bank_name',
                            'address',
                            'account_name',
                            'user_id_foreign',
                            'img'
                         ];

    public function units()
    {
        return $this->hasMany('App\Unit', 'unit_id');
    }
}

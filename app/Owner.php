<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $primaryKey = 'owner_id';

    protected $fillable = [
                                'date_invested', 
                                'unit_owner',
                                'investor_representative',
                                'investor_email_address',
                                'investor_contact_no',
                                'account_number',
                                'bank_name',
                                'investor_address',
                                'contract_start',
                                'contract_end',
                                'discount',
                                'investment_price',
                                'investment_type',
                                'unit_owner',
                                'date_accepted'
                            ];

    public function units()
    {
        return $this->hasMany('App\Unit', 'owner_id');
    }
}

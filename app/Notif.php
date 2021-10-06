<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
        protected $fillable = [
            'user_id_foreign',
            'message',
            'type',
            'property_id_foreign',
            'isOpen',
            'created_at',
            'updated_at',
            'amount'
        ];
}

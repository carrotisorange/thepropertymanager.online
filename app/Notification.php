<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'user_id_foreign',
        'message',
        'type',
        'property_id_foreign',
        'isOpen'
    ];
}

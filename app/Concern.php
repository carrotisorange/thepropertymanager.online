<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concern extends Model
{
    protected $primaryKey = 'concern_id';

    protected $fillable = [
        'reported_at', 
        'concern_unit_id',
        'concern_tenant_id',
        'contact_no',
        'details',
        'urgency',
        'is_warranty',
        'scheduled_at',
        'concern_user_id',
        'details',
        'resolved_by',
        'status',
         'rating',
         'remarks',
         'action_taken',
         'resolved_at',
         'category'
    ];

    public function tenant()
    {
    return $this->belongsTo('App\Tenant');
    }

    public function owner()
    {
    return $this->belongsTo('App\Owner', 'owner_id_foreign');
    }

    public function personnel()
    {
    return $this->belongsTo('App\Personnel', 'concern_personnel_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function responses()
    {
        return $this->hasMany('App\Response', 'concern_id_foreign')->orderBy('responses.created_at', 'desc');
    }


}

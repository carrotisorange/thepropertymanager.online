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
         'category',
         'assessed_at',
         'assessed_by_id',
         'assessment',
         'scope_of_work',
         'ended_on',
         'approved_by_tenant_at',
         'approved_by_owner_at',
         'payee',
         'payment_options'
    ];

    public function tenant()
    {
    return $this->belongsTo(Tenant::class);
    }

    public function room()
    {
        return $this->belongsTo(Unit::class);
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

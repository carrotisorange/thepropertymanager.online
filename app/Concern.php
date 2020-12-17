<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concern extends Model
{
    protected $primaryKey = 'concern_id';

    protected $fillable = [
                        'concern_tenant_id',
                        'concern_personnel_id',
                        'category',
                        'reported_at',
                        'is_warranty',
                        'urgency',
                        'unit_id_foreign',
                        'title',
                        'concern_qty',
                        'details',
                        'status',
                        'concern_amt',
                        'is_paid',
                        'rating'
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

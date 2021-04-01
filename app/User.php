<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'property',
         'status', 
         'user_type',
         'property_type', 
         'property_ownership', 
         'last_login_at',
         'last_logout_at',  
         'last_login_ip',
         'user_current_status',
         'account_type',
         'email_verified_at',
         'note',
         'trial_ends_at',
         'mobile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function properties()
    {
        return $this->hasMany('App\Property', 'user_id_property');
    }

    public function concerns()
    {
        return $this->hasMany('App\Concern', 'concern_user_id');
    }

    public function blogs()
    {
        return $this->hasMany('App\Blog', 'user_id_foreign');
    }

    public function users()
    {
        return $this->hasMany('App\User', 'lower_access_user_id');
    }

    public function units()
    {
        return $this->hasMany('App\Property', 'user_id_property')->where('unit_id', 'property_id_foreign')->count();
    }

    public function sessions()
    {
        return $this->hasMany('App\Session', 'session_user_id');
    }

    public function access()
    {
        return $this->hasMany('App\Tenant', 'user_id_foreign');
    }

    public function owner_access()
    {
        return $this->hasMany('App\Owner', 'user_id_foreign');
    }

    public function referrals()
    {
        return $this->hasMany('App\Contract', 'referrer_id_foreign');
    }

    public function issues()
    {
        return $this->hasMany('App\Issue', 'user_id_foreign')->orderBy('created_at', 'desc');
    }











}

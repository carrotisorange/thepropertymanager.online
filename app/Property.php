<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'properties';

    protected $primaryKey = 'property_id';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'property_type_id_foreign',
        'type',
        'ownership',
        'status',
        'address',
        'country',
        'zip'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function units()
    {
        return $this->hasMany('App\Unit', 'property_id_foreign')->orderBy('floor', 'asc')->orderBy('building', 'asc')->orderBy('unit_no', 'asc');
    }

    public function personnels()
    {
        return $this->hasMany('App\Personnel', 'property_id_foreign');
    }

    public function occupancy_rate()
    {
        return $this->hasMany('App\OccupancyRate', 'property_id_foreign');
    }

    public function current_occupancy_rate()
    {
        return $this->hasMany('App\OccupancyRate', 'property_id_foreign');
    }

    public function unseen_notifications()
    {
        return $this->hasMany('App\Notif', 'property_id_foreign')->orderBy('created_at', 'desc')->limit(5);
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification', 'property_id_foreign')->orderBy('created_at', 'desc');
    }
    
}

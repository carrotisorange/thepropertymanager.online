<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issues';

    protected $primaryKey = 'issue_id';

    protected $fillable = [
        'category',
        'details',
        'reported_by',
        'status'
    ];

    
}

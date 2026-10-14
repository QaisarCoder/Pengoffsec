<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name', 'email', 'company', 'service_required', 
        'project_type', 'budget', 'timeline', 'project_details', 'status'
    ];
}

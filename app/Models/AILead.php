<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AILead extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'company', 'service_required', 
        'requirements', 'callback_time', 'conversation_summary', 'status'
    ];
}

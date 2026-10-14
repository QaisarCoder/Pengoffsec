<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Appointment extends Model
{
    protected $fillable = [
        'reference', 'client_name', 'client_email', 'client_phone', 'service',
        'preferred_date', 'preferred_time', 'message', 'status',
        'email_sent', 'whatsapp_sent', 'email_error', 'whatsapp_error'
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    protected $casts = [
        'email_sent' => 'boolean',
        'whatsapp_sent' => 'boolean',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Combined preferred date + time, or null when either part is missing.
     * The assistant collects these as two separate strings, so the admin
     * views need a single sortable datetime to order and filter by.
     */
    public function getScheduledAtAttribute(): ?Carbon
    {
        if (empty($this->preferred_date)) {
            return null;
        }

        $date = trim((string) $this->preferred_date);
        $time = trim((string) $this->preferred_time);

        try {
            return $time !== ''
                ? Carbon::createFromFormat('Y-m-d H:i', "$date $time")
                : Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
        } catch (\Throwable) {
            try {
                return Carbon::parse($date);
            } catch (\Throwable) {
                return null;
            }
        }
    }
}

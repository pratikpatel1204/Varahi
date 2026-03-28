<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'year',
        'month',
        'date',
        'punch_in',
        'punch_out',
        'total_hours',
        'is_manual',
        'reason',
        'status',
        'reporting_manager_id',
        'approved_by',
        'reject_comment'
    ];

    protected $casts = [
        'date' => 'date',
        'punch_in' => 'datetime:H:i:s',
        'punch_out' => 'datetime:H:i:s',
        'is_manual' => 'boolean',
    ];

    // Employee
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Approved By (Manager/Admin)
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Today's attendance
    public function scopeToday($query)
    {
        return $query->whereDate('date', Carbon::today());
    }

    // Only pending requests
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    // Get formatted total hours
    public function getFormattedHoursAttribute()
    {
        return $this->total_hours ?? '00:00:00';
    }

    // Check if punched in
    public function getIsPunchedInAttribute()
    {
        return !is_null($this->punch_in);
    }

    // Check if punched out
    public function getIsPunchedOutAttribute()
    {
        return !is_null($this->punch_out);
    }
    public function scopeManagerScope($query)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['admin', 'super admin'])) {
            return $query->where('reporting_manager_id', $user->id);
        }
        return $query;
    }
}

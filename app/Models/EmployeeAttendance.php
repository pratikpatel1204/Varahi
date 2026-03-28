<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'employee_name',
        'employee_code',
        'year',
        'month',
        'total_days',
        'present_days',
        'sick_leave',
        'casual_leave',
        'paid_leave',
        'absent_days',
        'payable_days',
        'holiday_days'
    ];
}

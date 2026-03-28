<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryProcessStatus extends Model
{
    protected $table = 'salary_process_status';

    protected $fillable = [
        'year',
        'month',
        'attendance_verified',
        'loan_verified',
        'expense_verified',
        'salary_processed',
    ];

    protected $casts = [
        'attendance_verified'     => 'boolean',
        'loan_verified'           => 'boolean',
        'expense_verified'        => 'boolean',       
        'salary_processed'        => 'boolean',
    ];
}

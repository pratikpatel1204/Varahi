<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryLoanDeduction extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'loan_id',
        'year',
        'month',
        'deduction_amount',
    ];

    // Relationship with Employee
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    // Relationship with Loan
    public function loan()
    {
        return $this->belongsTo(LoanManagement::class, 'loan_id');
    }
}

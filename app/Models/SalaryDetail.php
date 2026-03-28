<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetail extends Model
{
    use HasFactory;

    protected $table = 'salary_details';

    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'type',
        'category',
        'value',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}

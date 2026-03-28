<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryType extends Model
{
    protected $fillable = ['name', 'type','value' ,'value_type'];
    
     public function employeeSalaries()
    {
        return $this->hasMany(EmployeeSalaryType::class);
    }
    public function employeeSalaryTypes()
{
    return $this->hasMany(EmployeeSalaryType::class);
}
}

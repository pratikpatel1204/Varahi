<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'employee_code',
        'name',
        'role',
        'email',
        'password',
        'show_password',
        'phone',
        'gender',
        'dob',
        'address',
        'department_id',
        'sub_department_id',
        'skill_type',
        'reporting_manager',
        'profile_image',
        'otp',
        'otp_verified',
        'fcm_token',
        'pf_applicable',
        'esic_applicable',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'pf_applicable' => 'boolean',
        'esic_applicable' => 'boolean',
    ];
    // -------------------------
    // Relationships
    // -------------------------

    public function profile()
    {
        return $this->hasOne(EmployeeProfile::class, 'employee_id');
    }

    // Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Sub Department
    public function subDepartment()
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id');
    }

    // Designation (role)
    public function designation()
    {
        return $this->belongsTo(Role::class, 'role', 'name');
    }

    // Manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'reporting_manager');
    }

    // Employees under this manager
    public function teamMembers()
    {
        return $this->hasMany(User::class, 'reporting_manager');
    }

    // Salary years for employee
    public function salaryYears()
    {
        return $this->hasMany(EmployeeSalaryYear::class, 'employee_id')->with('year');
    }

    // Salary types assigned to employee
    public function employeeSalaryTypes()
    {
        return $this->hasMany(EmployeeSalaryType::class, 'employee_id')->with('salaryType');
    }

    // Salary addons assigned to employee
    public function salaryAddons()
    {
        return $this->hasMany(EmployeeAddon::class, 'employee_id')->with('addonType');
    }
    public function bloodGroup()
{
    return $this->belongsTo(BloodGroup::class);
}

    // -------------------------
    // Scopes
    // -------------------------

    public function scopeEmpScope($query)
    {
        $user = auth()->user();

        if (!$user) {
            return $query->whereRaw('0 = 1');
        }

        if (!in_array($user->role, ['admin', 'super admin'])) {
            $query->where('id', $user->id);
        } else {
            $query->where('role', '!=', 'super admin');
        }

        return $query;
    }
}

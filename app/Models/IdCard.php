<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class IdCard extends Model
{
    protected $fillable = [
        'employee_id', 'template_id', 'generated_by',
        'employee_code', 'name', 'email', 'phone', 'gender',
        'dob', 'designation', 'department', 'blood_group',
        'site_name', 'joining_date', 'present_address',
        'present_city', 'present_state', 'emergency_phone_1',
        'company_name', 'company_phone', 'company_address',
        'company_logo', 'profile_image',
        'generated_content', 'generated_date',
    ];

    public function employee() { return $this->belongsTo(Employee::class); }
    public function template() { return $this->belongsTo(IdCardTemplate::class); }
}
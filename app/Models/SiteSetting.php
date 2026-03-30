<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $table = 'site_settings';

    protected $fillable = [
        'company_name',
        'company_logo',
        'company_address',
        'company_mobile'
    ];

    /**
     * Get first setting (helper)
     */
    public static function getSetting()
    {
        return self::first();
    }
    
      public function employees()
    {
        return $this->hasMany(Employee::class,'company_id');
    }
}

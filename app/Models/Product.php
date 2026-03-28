<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'image',
        'status',
        'created_by'
    ];

    // relation
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
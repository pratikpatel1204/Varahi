<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class IdCardTemplate extends Model
{
    protected $fillable = ['name', 'content', 'is_active'];
}
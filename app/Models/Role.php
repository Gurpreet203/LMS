<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = [
        'name',
        'slug',
    ];

    const SUB_ADMIN = 2;
    const EMPLOYEE = 3;
    const TRAINER = 4;

    public function scopeList($query)
    {
        return $query
            ->where('name','!=','Admin')
            ->get();
    }
}

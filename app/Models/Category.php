<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $fillable = [
        'name',
        'slug',
        'created_by',
        'courses',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function scopeSearch($query ,array $filter)
    {
        $query->when($filter['search']??false, function($query , $search) {
           return $query
            ->where('name','like','%'.$search.'%');
        });

        $query->when($filter['date'] ?? false, function($query , $search){
            return $query
            ->orderBy('created_at', 'DESC');
        });
    }

    public static function createSlug($name)
    {
        $name = trim($name);
        $name = str_replace(' ','-',$name);
        $name = strtolower($name);
        
        return $name;
    }
}

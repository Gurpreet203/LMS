<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes, Sluggable;

    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $fillable = [
        'name',
        'slug',
        'created_by',
        'courses',
        'status',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name']
            ]
        ];
    }

    public static function valid()
    {
        return self::pluck('id')->toArray();
    }

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
}

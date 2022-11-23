<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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

    // public static function valid()
    // {
    //     return self::visible_to()->active()->pluck('id')->toArray();
    // }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeVisibleTo($query)
    {
        return $query->where('created_by', Auth::id());
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

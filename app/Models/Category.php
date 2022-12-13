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

    // scopes

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeVisibleTo($query)
    {
        if (Auth::user()->role_id == Role::TRAINER)
        {
            return $query->where('created_by', 1);
        }
        return $query->where('created_by', Auth::id());
    }

    public function scopeSearch($query ,array $filter)
    {
        $query->when($filter['search']??false, function($query , $search) {
           return $query
            ->where('name','like','%'.$search.'%');
        });

        $query->when($filter['sort'] ?? false, function($query , $search){
            if($search == 'A-Z')
            {
                return $query->orderBy('name');
            }
            elseif($search == 'Z-A')
            {
                return $query->orderBy('name', 'DESC');
            }
            elseif($search == 'oldest')
            {
                return $query->orderBy('created_at', 'ASC');
            }
        });
    }

    // relationships

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}

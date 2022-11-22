<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, Sluggable;

    const CERTIFICATE = 1;
    const NOCERTIFICATE = 0;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'user_id',
        'category_id',
        'status_id',
        'level_id',
        'certificate'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title']
            ]
        ];
    }

    public function scopeSearch($query ,array $filter)
    {
        $query->when($filter['search'] ?? false, function($query , $search) {
            return $query
             ->where('title','like','%'.$search.'%')
             ->orwhere('description','like','%'.$search.'%');
         });

       $query->when($filter['status'] ?? false, function($query , $search) {
           return $query->where('status_id', $search);
        });

        $query->when($filter['category'] ?? false, function($query , $search){
            return $query->where('category_id' , $search);
        });

        $query->when($filter['level'] ?? false, function($query , $search){
            
            return $query->where('level_id', $search);
        });

        $query->when($filter['sort'] ?? false, function($query , $search){
            
            if($search == 'A-Z')
            {
                return $query->orderBy('title');
            }
            elseif($search == 'Z-A')
            {
                return $query->orderBy('title', 'DESC');
            }
            elseif($search == 'latest')
            {
                return $query->orderBy('created_at', 'DESC');
            }
        });
    }

    public function getAllCoursesAttribute()
    {
        return $this->status_id.' '.$this->category_id;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'course_units');
    }

    

    public function publishCount()
    {
        return self::where('status_id', Status::PUBLISHED)->count();
    }
    public function archieveCount()
    {
        return self::where('status_id', Status::ARCHIEVED)->count();
    }
    public function draftCount()
    {
        return self::where('status_id', Status::DRAFT)->count();
    }

    public function allCount()
    {
        return self::all()->count();
    }
}

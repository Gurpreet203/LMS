<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;

class User extends Authenticatable
{

    
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ReceivesWelcomeNotification, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'role_id',
        'slug',
        'email',
        'created_by',
        'gender',
        'phone',
        'password',
        'image',
        'email_status',
        'status'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['first_name', 'last_name']
            ]
        ];
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function category()
    {
        return $this->hasMany(Category::class);
    }

    public function scopeSearch($query ,array $filter)
    {
       $query->when($filter['search'] ?? false, function($query , $search) {
           return $query
            ->where('first_name','like','%'.$search.'%')
            ->orwhere('email','like','%'.$search.'%');
        });

        $query->when($filter['role'] ?? false, function($query , $search){
            return $query
            ->where('role_id' , $search);
        });

        $query->when($filter['date'] ?? false, function($query , $search){
            return $query
            ->orderBy('created_at', 'DESC');
        });
    }

    public static function createSlug($first_name,$last_name)
    {

        $slug = strtolower($first_name).'-'.strtolower($last_name);

        $slugs = self::select('slug')->where('slug', 'like', $slug.'%')->get();

        if(!$slugs->contains('slug',$slug))
        {
            return $slug;
        }

        $i =1;
        
        do {
            $newSlug = $slug.'-'.$i;
            if(!$slugs->contains('slug',$newSlug))
            {
                return $newSlug;
            }
            $i++;
        }while(true);
    }

    public function getIsEmployeeAttribute()
    {
        return $this->role_id == Role::EMPLOYEE;
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }
}

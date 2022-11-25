<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;

class User extends Authenticatable
{

    
    use HasApiTokens, HasFactory, SoftDeletes, ReceivesWelcomeNotification, Sluggable, Notifiable;

    const ACTIVE = 1;
    const INACTIVE = 0;

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

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function scopeVisibleTo($query)
    {
        return $query->where('created_by', Auth::id());
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }

    public function scopeIsEmployee($query)
    {
        return $query->where('role_id', Role::EMPLOYEE);
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

    public function enrollment()
    {
        return $this->belongsToMany(Course::class, 'course_users')
            ->withPivot('id', 'status')
            ->withTimestamps()
            ->get();
    }

    public function getIsEmployeeAttribute()
    {
        return $this->role_id == Role::EMPLOYEE;
    }

    public function getIsAdminAttribute()
    {
        return $this->role_id == Role::ADMIN;
    }

    public function getIsSubadminAttribute()
    {
        return $this->role_id == Role::SUB_ADMIN;
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }
}

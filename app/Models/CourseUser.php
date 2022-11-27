<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;

class CourseUser extends Pivot
{
    use HasFactory;

    protected $table = ['course_user']; 

    protected $fillable =[
        'user_id',
        'status',
        'created_by'
    ];

    public function user()
    {
        $this->hasMany(User::class);
    }

    public function course()
    {
        $this->hasMany(Course::class);
    }
}

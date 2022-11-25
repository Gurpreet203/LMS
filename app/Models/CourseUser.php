<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'status'
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

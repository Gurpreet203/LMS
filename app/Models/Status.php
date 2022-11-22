<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    
    const DRAFT = 1;
    const ARCHIEVED = 2;
    const PUBLISHED = 3;

    protected $fillable = [
        'name',
        'slug',
    ];

}

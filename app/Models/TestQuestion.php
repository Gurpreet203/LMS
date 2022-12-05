<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TestQuestion extends Pivot
{
    use HasFactory;

    // protected $table = 'test_question'; 

    protected $fillable = [
        'test_id',
        'question_id'
    ];
}

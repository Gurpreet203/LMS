<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'name',
        'duration',
        'pass_score'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'test_question')
            ->withPivot('id')
            ->withTimestamps()
            ->using(TestQuestion::class);
    }
}

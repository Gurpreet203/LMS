<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class)
            ->withPivot()
            ->using(TestQuestion::class);
    }

    public function option()
    {
        return $this->hasMany(Option::class);
    }
}

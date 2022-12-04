<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Option;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\Unit;
use Illuminate\Http\Request;

/// WIP  
// WIP

class QuestionController extends Controller
{
    public function create(Course $course, Unit $unit, Test $test)
    {
        return view('trainers.question.create', [
            'course' => $course,
            'unit' => $unit,
            'test' => $test
        ]);
    }

    public function store(Request $request, Course $course, Unit $unit, Test $test)
    {
        $attributes = $request->validate([
            'question' => 'required|min:3',
            'options' => 'required|min:2|max:255',
            'radio' => 'required|min:1|gt:0'
        ]);
        $question = Question::create([
            'question' => $attributes['question']
        ]);

        TestQuestion::create([
            'test_id' => $test->id,
            'question_id' => $question->id
        ]);

       $options = collect($attributes['options']);

       $options->each(function($option) use($question) {
            Option::create([
            'question_id' => $question->id,
            'option' => $option
        ]);
       });

       return back()->with('status', 'Successfully Created');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return back()->with('status', 'Successfully Deleted');
    }
}

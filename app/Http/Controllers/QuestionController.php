<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Option;
use App\Models\Question;
use App\Models\Test;
use App\Models\Unit;
use Illuminate\Http\Request;


//WIP

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

    public function store(Request $request, Test $test)
    {
        // dd($request->all());
        $attributes = $request->validate([
            'question' => 'required|min:3',
            'options' => 'required|min:2|max:255|array',
            'radio' => 'required|min:1|gt:0'
        ]);

        $question = Question::create([
            'question' => $attributes['question']
        ]);

        $question->test()->attach($test);

       $options = collect($attributes['options']);

       $i =0;

       $options->each(function($option) use($question, &$i, $attributes) {
            $i++;

            if($i == $attributes['radio'])
            {
                Option::create([
                    'question_id' => $question->id,
                    'option' => $option,
                    'answer' => 1
                ]);
            }
            else
            {
                Option::create([
                    'question_id' => $question->id,
                    'option' => $option
                ]);
            }
        });

       return back()->with('status', 'Successfully Created');
    }

    public function edit(Course $course, Unit $unit, Test $test, Question $question)
    {
        return view('trainers.question.edit', [
            'course' => $course,
            'unit' => $unit,
            'test' => $test,
            'question' => $question
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $attributes = $request->validate([
            'question' => 'required|min:3',
            'options' => 'array|required|min:2|max:255',
            'radio' => 'required|min:1|gt:0'
        ]);
        // dd($request->all());
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return back()->with('status', 'Successfully Deleted');
    }
}

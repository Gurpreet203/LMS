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
        return view('trainers.courses.units.test.question.create', [
            'course' => $course,
            'unit' => $unit,
            'test' => $test
        ]);
    }

    public function store(Request $request, Course $course, Unit $unit, Test $test)
    {
        $attributes = $request->validate([
            'question' => 'required|min:3',
            'options' => 'array|size:2',
            'options.*' => 'required|min:3|max:255',
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

            if ($i == $attributes['radio'])
            {
                Option::create([
                    'question_id' => $question->id,
                    'option' => $option,
                    'answer' => true
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

        if($request['save'] == 'save')
        {
            return to_route('test.edit', [$course, $unit, $test])->with('status', 'Successfully Created');
        }

       return back()->with('status', 'Successfully Created');
    }

    public function edit(Course $course, Unit $unit, Test $test, Question $question)
    {
        return view('trainers.courses.units.test.question.edit', [
            'course' => $course,
            'unit' => $unit,
            'test' => $test,
            'question' => $question
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required|min:3',
            'options' => 'array|size:2',
            'options.*' => 'required|min:3|max:255',
            'radio' => 'required|min:1|gt:0'
        ]);

        $question->update([
            'question' => $request['question']
        ]);

       $i =0;

       $question->options()->each(function($option) use(&$i, $request) {
            
            if ($i+1 == $request['radio'])
            {
                $option->update([
                    'option' => $request['options'][$i],
                    'answer' => true
                ]);
            }
            else
            {
                $option->update([
                    'option' => $request['options'][$i],
                    'answer' => false
                ]);
            }
            $i++;
        });

       return back()->with('status', 'Successfully Updated');

    }

    public function destroy(Question $question)
    {
        $question->delete();

        return back()->with('status', 'Successfully Deleted');
    }
}

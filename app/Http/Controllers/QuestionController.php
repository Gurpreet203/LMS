<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
            'options' => 'array|min:2',
            'options.*' => 'required|min:3|max:255',
            'radio' => 'required|min:1|gt:0'
        ], [
            'options.*.required' => 'The Option field is required',
            'options.*.min' => 'The minimum lenght should be of 3 characters',
            'options.*.max' => 'The maximum lenght should be of 255 characters',
            'radio.required' => 'Answer field is required'
        ]);

        $question = Question::create([
            'question' => $attributes['question']
        ]);

        $question->test()->attach($test);

        $i =1;
        collect($attributes['options'])
            ->each(function($option) use($question, &$i, $attributes) {

                $answer = $question->options()->create([
                    'option' => $option
                ]);

                if ($i == $attributes['radio'])
                {
                   $answer->update([
                        'answer' => true
                    ]);
                }
                $i++;
            });

        if($request['save'] == 'save')
        {
            return to_route('test.edit', [$course, $unit, $test])->with('status', 'Successfully Created');
        }

       return back()->with('status', 'Successfully Created');
    }

    public function edit(Course $course, Unit $unit, Test $test, Question $question)
    {
        $this->authorize('update', $course);

        return view('trainers.courses.units.test.question.edit', [
            'course' => $course,
            'unit' => $unit,
            'test' => $test,
            'question' => $question
        ]);
    }

    public function update(Request $request, Course $course, Question $question)
    {
        $this->authorize('update', $course);
        
        $request->validate([
            'question' => 'required|min:3',
            'options' => 'array|size:2',
            'options.*' => 'required|min:3|max:255',
            'radio' => 'required|min:1|gt:0'
        ],  [
            'options.*.required' => 'The Option field is required',
            'options.*.min' => 'The minimum lenght should be of 3 characters',
            'options.*.max' => 'The maximum lenght should be of 255 characters',
            'radio.required' => 'Answer field is required'
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

    public function destroy(Course $course ,Question $question)
    {
        $this->authorize('update', $course);
        
        $question->delete();

        return back()->with('status', 'Successfully Deleted');
    }
}

<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestSession;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LearnerUnitController extends Controller
{

    public function view(Course $course, Unit $unit)
    {
        return view('learner.course.unit.view', [
            'course' => $course,
            'unit' => $unit
        ]); 
    }

    public function show(Course $course, Unit $unit, Test $test)
    {
        return view('learner.course.unit.test.show', [
            'course' => $course,
            'unit' => $unit,
            'question' => $test->questions()->first(),
            'test' => $test
        ]);
    }

    public function store(Request $request, Course $course, Unit $unit, Test $test, Question $question)
    {
        $request->validate([
            'answer' => ['required', 
                Rule::in($question
                    ->options()
                    ->get()
                    ->pluck('id')
                    ->toArray()
            )]
        ]);

        if (TestSession::where('test_id', $test->id)->first() != null)
        {
            return to_route('my-courses.units.view', [$course, $unit])
                ->with('error', 'Already Test Attempted');
        }

        if ($request['answer'] == $question->options()->Answer()->first()->id)
        {
            if ($request->session()->has('correct'))
            {
                $request->session()->put('correct', $request->session()->get('correct')+1);
            }
            else
            {
                $request->session()->put('correct', 1);
            }
        }
        else
        {
            if ($request->session()->has('wrong'))
            {
                $request->session()->put('wrong', $request->session()->get('wrong')+1);
            }
            else
            {
                $request->session()->put('wrong', 1);
            }
        }

        $question = Question::where('id', '>', $question->id)->first();

        if ($question == null || $question->test()->first()->pivot->test_id != $test->id)
        {
            $marks = $test->questions()->count() ? 100 / $test->questions()->count() : 0;
            $totalMarks = $request->session()->get('correct') * $marks;

            $testSession = TestSession::create([
                'user_id' => Auth::id(),
                'test_id' => $test->id,
                'answers_correct' => $request->session()->get('correct') ?? false,
                'answers_wrong' => $request->session()->get('wrong') ?? false,
                'marks_obtained' => $totalMarks
            ]);
            $request->session()->forget(['correct', 'wrong']);

            return view('learner.course.unit.test.result', [
                'course' => $course,
                'unit' => $unit,
                'PassFail' => $totalMarks >= $test->pass_score ? true : false,
                'result' => $testSession->marks_obtained
            ]);
        }

        return view('learner.course.unit.test.show', [
            'course' => $course,
            'unit' => $unit,
            'question' => $question,
            'test' => $test
        ]);
    }
}
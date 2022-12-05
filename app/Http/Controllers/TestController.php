<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Test;
use App\Models\Unit;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function create(Course $course, Unit $unit)
    {
        return view('trainers.test.create', [
            'course' => $course,
            'unit' => $unit
        ]);
    }

    public function store(Request $request, Course $course, Unit $unit)
    {
        $attributes = $request->validate([
            'name' => 'required|min:3|max:255',
            'duration' => 'required|numeric',
            'pass_score' => 'required|numeric|gt:0'
        ]);
        $attributes += [
            'unit_id' => $unit->id
        ];

        Test::create($attributes);

        if ($request['save'] == 'save')
        {
            return to_route('units.edit', [$course, $unit])->with('status', 'Successfully Test Created');
        }

        return back()->with('status', 'Successfully Test Created');
    }

    public function edit(Course $course, Unit $unit, Test $test)
    {
        return view('trainers.test.edit', [
            'course' => $course,
            'unit' => $unit,
            'test' => $test
        ]);
    }

    public function update(Request $request, Course $course, Unit $unit, Test $test)
    {
        $attributes = $request->validate([
            'name' => 'required|min:3|max:255',
            'duration' => 'required|numeric',
            'pass_score' => 'required|numeric|gt:0'
        ]);

        $test->update($attributes);

        return to_route('units.edit', [$course, $unit])->with('status', 'Successfully Test Updated');
    }

    public function destroy(Course $course, Unit $unit, Test $test)
    {
        $test->delete($test);

        return to_route('units.edit', [$course, $unit])->with('status', 'Successfully Test Updated');
    }
}

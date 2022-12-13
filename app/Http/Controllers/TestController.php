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
        return view('trainers.courses.units.test.create', [
            'course' => $course,
            'unit' => $unit
        ]);
    }

    public function store(Request $request, Course $course, Unit $unit)
    {
        $attributes = $request->validate([
            'name' => 'required|min:3|max:255',
            'duration' => 'required|numeric|gt:0',
            'pass_score' => 'required|numeric|between:1,100'
        ]);
        $attributes += [
            'unit_id' => $unit->id
        ];
        $test = Test::create($attributes);
        $unit->increment('duration', $request['duration']);

        $test->lessons()->create([
            'unit_id' => $unit->id,
            'duration' => $attributes['duration']
        ]);

        if ($request['save'] == 'save')
        {
            return to_route('test.edit', [$course, $unit, $test])
                ->with('status', 'Successfully Test Created');
        }

        return back()->with('status', 'Successfully Test Created');
    }

    public function edit(Course $course, Unit $unit, Test $test)
    {
        $this->authorize('update', $course);

        return view('trainers.courses.units.test.edit', [
            'course' => $course,
            'unit' => $unit,
            'test' => $test
        ]);
    }

    public function update(Request $request, Course $course, Unit $unit,Test $test)
    {
        $this->authorize('update', $course);

        $attributes = $request->validate([
            'name' => 'required|min:3|max:255',
            'duration' => 'required|numeric|gt:0',
            'pass_score' => 'required|numeric|between:1,100'
        ]);
        if ($test->duration < $attributes['duration'])
        {
            $unit->decrement('duration', $test->duration);
            $unit->increment('duration', $attributes['duration']);
        }
        elseif ($test->duration > $attributes['duration'])
        {
            $unit->decrement('duration', $test->duration);
            $unit->increment('duration', $attributes['duration']);
        }

        $test->update($attributes);
        $test->lessons()->update([
            'duration' => $attributes['duration']
        ]);

        return back()->with('status', 'Successfully Test Updated');
    }

    public function destroy(Course $course, Test $test)
    {
        $this->authorize('delete', $course);

        $test->delete($test);

        return back()->with('status', 'Successfully Test Updated');
    }
}

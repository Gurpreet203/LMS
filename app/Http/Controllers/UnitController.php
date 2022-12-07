<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUnit;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function create(Course $course)
    {
        return view('trainers.courses.units.create', [
            'course' => $course
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $attributes = $request->validate( [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:5'
        ]);
       
        $unit = Unit::create($attributes);

        CourseUnit::create([
            'course_id' => $course->id,
            'unit_id' => $unit->id
        ]);

        if ($request['save'] == 'save')
        {            
            return to_route('courses.show', $course)->with('status', 'Successfully Created');
        }

        return back()->with('status', 'Successfully Created');
    }

    public function edit(Course $course, Unit $unit)
    {
        return view('trainers.courses.units.edit', [
            'unit' => $unit,
            'course' => $course
        ]);
    }

    public function update(Request $request, Course $course, Unit $unit)
    {
        $attributes = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:5'
        ]);

        $unit->update($attributes);

        return to_route('courses.show',$course)->with('status', 'Successfully Unit Update');
    }

    public function destroy(Course $course, Unit $unit)
    {
        $unit->delete();

        return to_route('courses.show', $course)->with('status', 'Successfully deleted');
    }

}

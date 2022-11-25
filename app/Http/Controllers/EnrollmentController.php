<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnrollmentController extends Controller
{
    public function index(Course $course)
    {
        return view('enrollment.index', [
            'course' => $course,
            'users' => User::visibleTo()
                    ->active()
                    ->isEmployee()
                    ->get()
        ]);
    }

    public function store(Request $request, Course $course)
    {
        if ($course->status_id != Status::PUBLISHED)
        {
            return back()->with('error', 'Course is not published');
        }

        $attributes = $request->validate([
            'user_id' => ['required', Rule::in(
                User::visibleTo()
                ->active()
                ->isEmployee()
                ->get()
                ->pluck('id')
                ->toArray()
            )]
        ]);
        // dd($course->enroll());
      
        $course->enroll()->attach($attributes['user_id']);

        return to_route('courses');
    }
}

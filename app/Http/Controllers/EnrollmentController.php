<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EnrollmentController extends Controller
{
    public function index(Course $course)
    {
        $users = User::visibleTo()
            ->active()
            ->whereDoesntHave('enrollments', function($query)use($course) {
                $query->where('course_id', $course->id);
            })
            ->employee()
            ->get();

        return view('enrollment.index', [
            'course' => $course,
            'users' => $users,
            'enrolledUsers' => $course->enrollments()->get()
        ]);
    }

    public function store(Request $request, Course $course)
    {
        if ($course->status_id != Status::PUBLISHED)
        {
            return back()->with('error', 'Course is not published');
        }

        $attributes = $request->validate([
            'user_id' => ['required', 
                Rule::in(User::visibleTo()
                            ->active()
                            ->whereDoesntHave('enrollments', function($query)use($course) {
                                $query->where('course_id', $course->id);
                            })
                            ->employee()
                            ->get()
                            ->pluck('id')
                            ->toArray()
            )]
        ]);
      
        $course->enrollments()->attach($attributes['user_id'], ['created_by' => Auth::id()]);

        return back()->with('status', 'Succcessfuly enrolled');
    }

    public function destroy(User $user, Course $course)
    {
        $course->detach($user);

        return back()->with('status', 'Successfully unernrolled');
    }
}

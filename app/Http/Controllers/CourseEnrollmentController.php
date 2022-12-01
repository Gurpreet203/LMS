<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Notifications\EnrollmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CourseEnrollmentController extends Controller
{
    public function index(User $user)
    {
        $courses = Course::whereDoesntHave('enrollments', function($query)use($user) {
                        $query->where('user_id', $user->id);
                    })
                    ->visibleTo()
                    ->publish()
                    ->get();

        return view('users.enrollCourse', [
            'courses' => $courses,
            'user' => $user,
            'enrolledCourses' => $user->enrollments()->get()
        ]);
    }

    // enrolled multiple courses to one user (1 user -> multiple courses)

    public function store(Request $request, User $user)
    {
         $attributes = $request->validate([
            'course_ids' => [
                'required',
                'array',
                'min:1', 
                Rule::in(Course::whereDoesntHave('enrollments', function($query)use($user) {
                        $query->where('user_id', $user->id);
                    })
                    ->publish()
                    ->visibleTo(Auth::user())
                    ->get()
                    ->pluck('id')
                    ->toArray(),
                )
            ]
        ]);
        
        $user->enrollments()->attach($attributes['course_ids'],
            [
                'created_by' => Auth::id()
            ]
        );

        $course = implode(" , ",
                    Course::find($attributes['course_ids'])
                        ->pluck('title')
                        ->toArray()
                );

        Notification::send($user, new EnrollmentNotification(Auth::user(), $course));

        return back()->with('status', 'Succcessfuly Enrolled');
    }

    public function destroy(User $user, Course $course)
    {
        $user->enrollments()->detach($course->id);

        return back()->with('status', 'Successfully Unenroll');
    }
}

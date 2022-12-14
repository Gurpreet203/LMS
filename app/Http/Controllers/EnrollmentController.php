<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Status;
use App\Models\User;
use App\Notifications\EnrollmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
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

        return view('trainers.courses.enrollment', [
            'course' => $course,
            'users' => $users,
            'enrolledUsers' => $course->enrollments()->get()
        ]);
    }

    // enrolled multiple users into one course (1 Course -> multiple users)

    public function store(Request $request, Course $course)
    {
        if ($course->status_id != Status::PUBLISHED)
        {
            return back()->with('error', 'Course is not published');
        }

        $attributes = Validator::make($request->all(), [
            'user_ids' => [
                'required',
                'array',
                'min:1',
                Rule::in(User::visibleTo(Auth::user())
                    ->whereDoesntHave('enrollments', function ($query) use ($course) {
                        $query->where('course_id', $course->id);
                    })->get()
                    ->pluck('id')
                    ->toArray()),
            ],
        ]);
      
        $validated = $attributes->validated();
        $course->enrollments()->attach($validated['user_ids'], 
            [
                'created_by' => Auth::id()
            ]);
            
        Notification::send(User::find($validated['user_ids']), new EnrollmentNotification(Auth::user(), $course));
        
        return back()->with('status', 'Succcessfuly enrolled');
    }

    public function destroy(Course $course, User $user)
    {
        $course->enrollments()->detach($user->id);

        return back()->with('status', 'Successfully unernrolled');
    }
}

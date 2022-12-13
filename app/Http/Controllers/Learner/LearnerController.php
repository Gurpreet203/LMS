<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearnerController extends Controller
{
    public function index()
    {
        return view('learner.index', [
            'courses' => Course::whereHas('enrollments', function($query) {
                            $query->where('user_id', Auth::id());
                        })
                ->publish()
                ->get()
        ]);
    }

    public function view(Course $course)
    {
        return view('learner.course.show', [
            'course' => $course
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $id = Auth::id() ;

        $courses = Course::with(["enrollments" => function ($query)use($id) {
                $query->where('user_id', $id);
            }])
            ->whereHas('enrollments',function ($query)use($id){
                $query->where('user_id', $id);
            })
            ->get();

        return view('employee.index', [
            'courses' => $courses
        ]);
    }
}

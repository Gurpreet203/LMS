<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Level;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        // old code which is worked but way is wrong 

        // $id = Auth::id();

        // $courses = Course::with(["enrollments" => function ($query)use($id) {
        //         $query->where('user_id', $id);
        //     }])
        //     ->whereHas('enrollments',function ($query)use($id){
        //         $query->where('user_id', $id);
        //     })
        //     ->get();
       
        $id = Auth::id();
        $user = User::find($id);

        $courses = $user->enrollments()->publish()->get();

        return view('employee.index', [
            'courses' => $courses,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Level;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseControllerr extends Controller
{
    public function index()
    {
        return view('courses.index', [
            'count' => new Course,
            'courses' => Course::latest()->where('user_id', Auth::id())->search(request(['status','level','category','search','sort']))->get(),
            'categories' => Category::get(),
            'levels' => Level::get(),
            'statuses' => Status::get()
        ]);
    }

    public function create()
    {
        return view('courses.create', [
            'categories' => Category::get(),
            'levels' => Level::get(),
            'statuses' => Status::get()
        ]);
    }

    public function store(Request $request)
    {
        
        $attributes = $request->validate([
            'title' => ['required', 'min:2', 'max:255'],
            'description' => ['required', 'min:5'],
            'category_id' => ['required',
                Rule::in(array_values( Category::valid() ))
            ],
            'level_id' => ['required',
                Rule::in(array_values( Level::valid() ))
            ]
        ]);

        $attributes +=[
            'user_id' => Auth::id(),
            'certificate' => $request['certificate']? Course::CERTIFICATE : Course::NOCERTIFICATE,
            'status_id' => Status::DRAFT,
        ];
               
        Course::create($attributes);

        if($request['save'] == 'save')
        {
            return to_route('courses')->with('status', 'Successfully Created');
        }

        return back()->with('status','Successfully Created');
    }

    public function edit(Course $course)
    {
        return view('courses.edit',[
            'course' => $course,
            'statuses' => Status::get(),
            'categories' => Category::get(),
            'levels' => Level::get()
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $attributes = $request->validate([
            'title' => ['required', 'min:2', 'max:255'],
            'description' => ['required', 'min:5'],
            'category_id' => ['required',
                Rule::in(array_values( Category::valid() ))
            ],
            'level_id' => ['required',
                Rule::in(array_values( Level::valid() ))
            ]
        ]);

        $attributes +=[
            'certificate' => $request['certificate']? Course::CERTIFICATE : Course::NOCERTIFICATE,
        ];

        $course->update($attributes);

        return to_route('courses')->with('status','Successfully Updated');
    }

    public function show(Course $course)
    {
        return view('courses.show', [
            'course' => $course
        ]);
    }
}

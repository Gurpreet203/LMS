<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseImage;
use App\Models\Level;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseControllerr extends Controller
{
    public function index()
    {
        return view('trainers.courses.index', [
            'courses' => Course::with('user','images','category','level','status')
                ->withCount('enrollments')
                ->latest()
                ->visibleTo()
                ->active()
                ->search(request([
                        'status',
                        'level',
                        'category',
                        'search',
                        'sort'
                    ]))
                ->get(),
            'categories' => Category::get(),
            'levels' => Level::get(),
            'statuses' => Status::get()
        ]);
    }

    public function create()
    {
        return view('trainers.courses.create', [
            'categories' => Category::active()
                ->visibleTo()
                ->get(),
            'levels' => Level::get(),
            'statuses' => Status::get()
        ]);
    }

    public function store(Request $request)
    { 
        $attributes = $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:5'],
            'category_id' => ['required',
                Rule::in(Category::active()
                    ->visibleTo(Auth::user())
                    ->get()
                    ->pluck('id')
                    ->toArray()
                )
            ],
            'level_id' => ['required',
                Rule::exists('levels', 'id')
            ],
            'image' => 'mimes:jpg,png,jpeg,gif'
        ]);

        $attributes +=[
            'user_id' => Auth::id(),
            'certificate' => $request['certificate'] ? true : false,
            'status_id' => Status::DRAFT,
        ];
        $course = Course::create($attributes);
        
        if ($request->file('image'))
        {
            $image = $request->file('image')->store('/images'); 
            CourseImage::create([
                'course_id' => $course->id,
                'image' => $image
            ]);  
        }

        if($request['save'] == 'save')
        {
            return to_route('courses')->with('status', 'Successfully Created');
        }

        return back()->with('status', 'Successfully Created');
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        return view('trainers.courses.edit', [
            'course' => $course,
            'statuses' => Status::get(),
            'categories' => Category::active()->visibleTo()->get(),
            'levels' => Level::get()
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);
        
        $attributes = $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:5'],
            'category_id' => ['required',
            Rule::in(Category::active()
                    ->visibleTo(Auth::user())
                    ->get()
                    ->pluck('id')
                    ->toArray()
                )
            ],
            'level_id' => ['required',
                Rule::exists('levels', 'id')
            ],
            'image' => ['mimes:jpg,png,jpeg,gif']
        ]);

        $attributes +=[
            'certificate' => $request['certificate'] ? true : false,
        ];

        $course->images->update([
            'image' => $request->file('image')->store('/images')
        ]);

        $course->update($attributes);

        return to_route('courses')->with('status', 'Successfully Updated');
    }

    public function show(Course $course)
    {
        $this->authorize('view', $course);
        
        return view('trainers.courses.show', [
            'course' => $course
        ]);
    }
}

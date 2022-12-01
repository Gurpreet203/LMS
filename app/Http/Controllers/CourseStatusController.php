<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Validation\Rule;

class CourseStatusController extends Controller
{
    public function __invoke(Course $course)
    {
        $this->authorize('update', $course);

        $attribute = request()->validate([
            'statusUpdate' => ['required', 
                    Rule::exists('statuses', 'id')
                ]
        ]);

        $course->update([
            'status_id' => $attribute['statusUpdate']
        ]);
        
        return to_route('courses');
    }
}

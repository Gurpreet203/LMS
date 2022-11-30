@extends('layouts.main')

@section('content')
    <x-nav />
    <div class="breadcrumbs-mine">
        <x-previousPageLink route="users" name="Users" current="Enroll Course"/>
    </div>
    @include('layouts.flashmessages')
    
    <div class="dropdown">
        <button class="btn-secondary right-dropdowns-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Add Course
            <span class="dropdown-toggle "></span>
        </button>
        <ul class="dropdown-menu">
            <form action="{{  route('enroll-courses.store', $user) }}" method="POST">
                @csrf
                @foreach ($courses as $course)
                    <li>
                        <input type="checkbox" value="{{$course->id}}" name="course_ids[]" class="form-check-input">
                        <label for="course_ids[]" class="form-check-label">{{ $course->title }}</label>
                    </li>
                @endforeach
                    <input type="submit" class="btn btn-secondary" value="Add" name="add">
            </form>
        </ul>
        <span class="text-danger">
            @error('course_ids')
                {{$message}}
            @enderror
        </span>
    </div>

    <div style="padding: 20px">
        <table class="table">
            <tr>
                <th>Title</th>
                <th>Status</th>
            </tr>
            
            @if ($enrolledCourses->count()>0)
                @foreach ($enrolledCourses as $course)
                    <tr>
                        <td>{{$course->title}}</td>
                        <td>
                            <form action="{{ route('enroll-courses.destroy', [$user, $course]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-secondary" value="Unenroll">
                            </form>
                        </td>
                    </tr>
                    
                @endforeach
            @else
                </table>
                <h3>No Course Found</h3>
            @endif
        </table>
    </div>
    
@endsection
        

       
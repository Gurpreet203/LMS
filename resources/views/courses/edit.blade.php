@extends('layouts.main')

@section('content')
    <x-nav />
    <div class="breadcrumbs-mine">
        <x-previousPageLink route="courses" name="Courses" current="Edit Course"/>
    </div>
    <form action="{{ route('courses.update', $course) }}" method="POST" class="create-form">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">What Will Be The Course Name?</label>
            <input type="text" name="title" class="form-control form-control-sm" required placeholder="Enter Course Name" value="{{$course->title}}">
            <span class="text-danger">
                @error('title')
                    {{$message}}
                @enderror
            </span>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Provide A Brief Description For What The Course About.</label>
            <textarea name="description" id="" cols="30" rows="5" class="form-control form-control-sm" required placeholder="Description">{{$course->description}}</textarea>
            <span class="text-danger">
                @error('description')
                    {{$message}}
                @enderror
            </span>
        </div>
       <div class="mb-3">
            <label for="category" class="form-label">Which Category Should The Course Be In?</label>
            <select name="category_id" id="" class="form-select form-select-sm">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" @if($course->category->id == $category->id) Selected @endif>{{$category->name}}</option>
                @endforeach
            </select>
            <span class="text-danger">
                @error('category_id')
                    {{$message}}
                @enderror
            </span>
       </div>
        <div class="mb-3">
            <label for="level" class="form-label">What Is The Level Of The Course</label>
            <select name="level_id" id="" class="form-select form-select-sm">
                @foreach ($levels as $level)
                    <option value="{{$level->id}}" @if($course->level->id == $level->id) Selected @endif>{{$level->name}}</option>
                @endforeach
            </select>
            <span class="text-danger">
                @error('level_id')
                    {{$message}}
                @enderror
            </span>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="certificate" id="flexCheckDefault">
            <label class="form-check-label" for="certificate">
              Certificate?
            </label>
        </div>
        <button type="submit" name="update" class="btn btn-secondary">Update</button>
        <a href="{{ route('courses') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
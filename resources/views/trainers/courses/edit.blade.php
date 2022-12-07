@extends('layouts.main')

@section('content')
    <x-nav />
    <div class="breadcrumbs-mine">
        <x-previousPageLink route="courses" name="Courses" current="Edit Course"/>
    </div>
    <form action="{{ route('courses.update', $course) }}" method="POST" class="create-form" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">What Will Be The Course Name?</label>
            <input type="text" name="title" class="form-control form-control-sm" required placeholder="Enter Course Name" value="{{$course->title}}">
            <x-error name='title' />
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Provide A Brief Description For What The Course About.</label>
            <textarea name="description" id="" cols="30" rows="5" class="form-control form-control-sm" required placeholder="Description">{{$course->description}}</textarea>
            <x-error name='description' />
        </div>
       <div class="mb-3">
            <label for="category" class="form-label">Which Category Should The Course Be In?</label>
            <select name="category_id" id="" class="form-select form-select-sm">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" @if($course->category->id == $category->id) Selected @endif>{{$category->name}}</option>
                @endforeach
            </select>
            <x-error name='category_id' />
       </div>
        <div class="mb-3">
            <label for="level" class="form-label">What Is The Level Of The Course</label>
            <select name="level_id" id="" class="form-select form-select-sm">
                @foreach ($levels as $level)
                    <option value="{{$level->id}}" @if($course->level->id == $level->id) Selected @endif>{{$level->name}}</option>
                @endforeach
            </select>
            <x-error name='level_id' />
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="certificate" id="flexCheckDefault">
            <label class="form-check-label" for="certificate">
              Certificate?
            </label>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Edit Course Image</label>
            <input type="file" name="image" class="form-control form-control-sm" placeholder="Edit Course Image" value="{{old('image')}}">
            <x-error name='image' />
        </div>
        <button type="submit" name="update" class="btn btn-secondary">Update</button>
        <a href="{{ route('courses') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
@extends('layouts.main')

@section('content')
    <x-nav />
    <div class="breadcrumbs-mine">
        <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><h4><a href="{{ route('courses') }}" style="text-decoration: none;">Course</a></h4></li>
                <li class="breadcrumb-item" ><h4><a href="{{ route('courses.show', $course) }}" style="text-decoration: none;width: 600px;">{{$course->title}}</a></h4></li>
                <li class="breadcrumb-item active" aria-current="page" style="width: 600px;"><h4>Edit Unit</h4></li>
            </ol>
        </div>
    </div>
    @include('layouts.flashmessages')
    
    <form action="{{ route('units.update',['course'=>$course,'unit'=>$unit]) }}" class="create-form" method="POST">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control form-control-sm" required placeholder="Enter Unit Name" value="{{$unit->title}}">
            <span class="text-danger">
                @error('title')
                    {{$message}}
                @enderror
            </span>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control form-control-sm" id="" cols="30" rows="5" required placeholder="Description">{{$unit->description}}</textarea>
            <span class="text-danger">
                @error('description')
                    {{$message}}
                @enderror
            </span>
        </div>
        <button type="submit" name="update" class="btn btn-secondary">Update</button>
        <a href="{{ route('courses.show',$course) }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
@endsection
@extends('layouts.main')

@section('content')
    <x-nav />
   <div class="course-content">
        <div class="breadcrumbs-mine">
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" ><h4><a href="{{ route('courses') }}" style="text-decoration: none;">Course</a></h4></li>
                    <li class="breadcrumb-item" ><a href="{{ route('units.edit', [$course, $unit]) }}" class="mine-bread">{{$unit->title}}</a></li>
                    <li class="breadcrumb-item active mine" aria-current="page">Add Test</li>
                </ol>
            </div>
        </div>
        <div style="margin: 20px">
            <a href="{{route('courses.show', $course)}}" class="btn btn-primary">Go To Course Content</a>
        </div>
   </div>
    @include('layouts.flashmessages')
        <form action="{{ route('test.store', [$course, $unit]) }}" class="create-form" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Title</label>
                <input type="text" name="name" class="form-control" required placeholder="Enter Test Name" value="{{old('name')}}">
                <span class="text-danger">
                    @error('name')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <div class="row g-3">
                <div class="col">
                    <label for="duration" class="form-label">Duration</label>
                    <input type="text" class="form-control" placeholder="in minutes" name="duration" value="{{old('duration')}}" required>
                    <span class="text-danger">
                        @error('duration')
                            {{$message}}
                        @enderror
                    </span>
                </div>
                
                <div class="col">
                    <label for="pass_score" class="form-label">Pass Score</label>
                    <input type="text" class="form-control" name="pass_score" value="{{old('pass_score')}}" required>
                    <span class="percent">%</span>
                    <span class="text-danger">
                        @error('pass_score')
                            {{$message}}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" value="save" name="save" class="btn btn-secondary">Save</button>
                <button type="submit" value="save-another" name="save" class="btn btn-secondary">Save & Add Another</button>
                <a href="{{ route('units.edit',[$course, $unit]) }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>

@endsection
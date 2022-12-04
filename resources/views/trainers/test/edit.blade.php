@extends('layouts.main')

@section('content')
    <x-nav />
    <div class="breadcrumbs-mine">
        <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><h4><a href="{{ route('courses') }}" style="text-decoration: none;">Course</a></h4></li>
                <li class="breadcrumb-item" ><a href="{{ route('courses.show', $course) }}" class="mine-bread">{{$course->title}}</a></li>
                <li class="breadcrumb-item" ><a href="{{ route('units.edit', [$course,$unit]) }}" class="mine-bread">{{$unit->title}}</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="width: 600px;"><h4>{{$test->name}}</h4></li>
            </ol>
        </div>
    </div>
    @include('layouts.flashmessages')
        <div class="add-test-link">
            <form action="{{ route('test.update', [$course, $unit, $test]) }}" class="create-form" method="POST">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Title</label>
                    <input type="text" name="name" class="form-control" required placeholder="Enter Test Name" value="{{$test->name}}">
                    <span class="text-danger">
                        @error('name')
                            {{$message}}
                        @enderror
                    </span>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <label for="duration" class="form-label">Duration</label>
                        <input type="text" class="form-control" placeholder="in minutes" name="duration" value="{{$test->duration}}">
                    </div>
                    <span class="text-danger">
                        @error('duration')
                            {{$message}}
                        @enderror
                    </span>
                    {{-- <div class="col">
                        <input type="text" class="form-control" placeholder="Last name">
                    </div> --}}
                </div>
                <div class="mt-3">
                    <button type="submit" name="update" class="btn btn-secondary">Update</button>
                    <a href="{{ route('units.edit',[$course, $unit]) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>

            <div>
                <div>
                <a href="{{ route('question.create', [$course, $unit, $test]) }}" class="test"><i class="bi bi-file-earmark-plus"></i> <span>Add Questions</span></a>
            </div>
            </div>
        </div>

@endsection
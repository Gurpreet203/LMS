@extends('layouts.main')

@section('content')
    <x-nav />
    <div class="course-content">
        <div class="breadcrumbs-mine">
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" ><h4><a href="{{ route('courses') }}" style="text-decoration: none;">Course</a></h4></li>
                    <li class="breadcrumb-item" ><a href="{{ route('units.edit', [$course,$unit]) }}" class="mine-bread">{{$unit->title}}</a></li>
                    <li class="breadcrumb-item active mine" aria-current="page">{{$test->name}}</li>
                </ol>
            </div>
        </div>
        <div style="margin: 20px">
            <a href="{{route('courses.show', $course)}}" class="btn btn-primary">Go To Course Content</a>
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
                        <input type="text" class="form-control" placeholder="in minutes" name="duration" value="{{$test->duration}}" required>
                            <span class="text-danger">
                                @error('duration')
                                    {{$message}}
                                @enderror
                            </span>
                    </div>
                    
                    <div class="col">
                        <label for="pass_score" class="form-label">Pass Score</label>
                        <input type="text" class="form-control" name="pass_score" value="{{$test->pass_score}}" required>
                        <span class="percent" style="top: 54%">%</span>
                            <span class="text-danger">
                                @error('pass_score')
                                    {{$message}}
                                @enderror
                            </span>
                    </div>
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

         <h1 style="margin-left: 20px">Questions</h1>
        

        <div>
            @foreach ($test->questions as $question)
            <section class="unit unit-details">
                <div class="unit-detail">
                    <div>
                        <i class="bi bi-grip-vertical" style="font-size: 25px;color:grey;"></i>
                    </div>
                    <div class="unit-detail-info">
                        <h3>{{$question->question}}</h3>
                    </div>
                </div>
                <div class="unit-detail-right">
                    <a href="{{ route('question.edit', [$course, $unit, $test, $question]) }}" class="unit-edit" style="width: 30px"><i  style="font-size: 18px;" class="bi bi-pencil-square"></i></a>
                    <form action="{{ route('question.destroy',[$course, $question]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </section>
        @endforeach
        </div>

@endsection
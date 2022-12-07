@extends('layouts.main')

@section('content')
    <x-nav />
    <div class="breadcrumbs-mine">
        <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><h4><a href="{{ route('courses') }}" style="text-decoration: none;">Course</a></h4></li>
                <li class="breadcrumb-item" ><a href="{{ route('courses.show', $course) }}" class="mine-bread">{{$course->title}}</a></li>
                <li class="breadcrumb-item active mine" aria-current="page">Edit Unit</li>
            </ol>
        </div>
    </div>
    @include('layouts.flashmessages')
    
    <div class="add-test-link">
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

        <div>
            <div>
                <a href="{{ route('test.create', [$course, $unit]) }}" class="test"><i class="bi bi-file-earmark-plus"></i> <span>Add Test</span></a>
            </div>
        </div>
    </div>

    <h1 style="margin-left: 20px">Lessons</h1>

    <div>
        @foreach ($unit->tests as $test)
        <section class="unit unit-details">
            <div class="unit-detail">
                <div>
                    <i class="bi bi-grip-vertical" style="color:grey;"></i>
                </div>
                <div class="unit-detail-info">
                    <h5>{{$test->name}}</h5>
                    <p style="margin: 5px 0;">{{$test->questions->count()}} Questions</p>
                </div>
            </div>
            <div class="unit-detail-right">
                <a href="{{ route('test.edit',[$course, $unit, $test]) }}" class="unit-edit" style="width: 30px"><i  style="font-size: 18px;" class="bi bi-pencil-square"></i></a>
                <form action="{{ route('test.destroy', $test) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </section>
    @endforeach
    </div>
@endsection
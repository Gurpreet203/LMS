@extends('layouts.main')

@section('content')
    <x-nav/>
    @include('layouts.flashmessages')

    <section>
        <div class="breadcrumbs-mine">
        <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><h4><a href="{{ route('my-courses.index') }}" style="text-decoration: none;">Course</a></h4></li>
                <li class="breadcrumb-item" ><a href="{{ route('my-courses.view', $course) }}" class="mine-bread">{{$course->title}}</a></li>
                <li class="breadcrumb-item active mine" aria-current="page">Unit Details</li>
              </ol>
        </div>
    </div>
     @if ($unit->tests->count()>0)
        @foreach ($unit->tests as $test)
        <section class="unit unit-details">
            <div class="unit-detail">
                <div>
                    <i class="bi bi-grip-vertical" style="color:grey;"></i>
                </div>
                <div class="unit-detail-info">
                    <a href="{{ route('my-courses.units.test.attempt', [$course, $unit, $test]) }}" class="title-link"><h5>{{$test->name}}</h5></a>
                    <p style="margin: 5px 0;">{{$test->questions->count()}} Questions</p>
                </div>
            </div>
            <div >
                <a href="{{ route('my-courses.units.test.attempt', [$course, $unit, $test]) }}" class="unit-edit" style="width: 30px"><i  style="font-size: 18px;" class="bi bi-pencil-square"></i> Attempt</a>
            </div>
        </section>
    @endforeach
    @else
        <h1>No Content Exist</h1>
    @endif
@endsection
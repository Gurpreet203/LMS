@extends('layouts.main')

@section('content')
    <x-nav/>

    <section>
        <div class="breadcrumbs-mine">
            <x-previousPageLink route="my-courses.index" name="Courses" current="Course Details" />
        </div>
        @if ($course->units->count()>0)
            @foreach ($course->units as $unit)
            <section class="unit">
                <div class="unit-details">
                    <div class="unit-detail">
                        <div>
                            <i class="bi bi-grip-vertical" style="font-size: 25px;color:grey;"></i>
                        </div>
                        <div class="unit-detail-info">
                            <h3><a href="" class="title-link">{{$unit->title}}</a></h3>
                            <p>{{$unit->description}}</p>
                        </div>
                    </div>
                    <div class="unit-detail-right">
                        <a href="{{ route('my-courses.units.view', [$course, $unit]) }}" class="unit-edit"><i class="bi bi-eye"></i> View Unit</a>
                    </div>
                </div>
                <div>
                    <h5 class="lessons-ui">Lessons <span>{{$unit->lessons->sum('duration')}} m</span></h5>
                    @if ($unit->tests->count()>0)
                        @foreach ($unit->tests as $test)
                            <a href="{{ route('my-courses.units.view', [$course, $unit]) }}" style="text-decoration: none;color:black;"><p class="lessons-detail">{{$test->name}} <span>{{$test->duration}} m</span></p></a>
                        @endforeach
                    @endif
                </div>
            </section>
        @endforeach
        @else
            <h1>No Content Exist</h1>
        @endif
    </section>
@endsection
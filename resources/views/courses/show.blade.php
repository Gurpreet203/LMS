@extends('layouts.main')

@section('content')
    <x-nav />
    @include('layouts.flashmessages')
    
    <section class="nav-bottom">
        <x-previousPageLink route="courses" name="Courses" current="{{$course->title}}"/>
        <div>
            <a href="{{ route('units',$course) }}" class="btn btn-primary" id="createbtn">Add Unit</a>
        </div>
    </section>

    <section class="course-show">
        
        <div class="course-show-detail">
            
            <div class="course-show-detail-left">
                <img src="https://img.freepik.com/free-vector/images-concept-illustration_114360-218.jpg?w=740&t=st=1669090866~exp=1669091466~hmac=086e2bd34fb211abbc01503852e809c7ea6d9ddf405b0e73ffa9f8d63ebdcb44" alt="loading">
                <div>
                    <h2>{{$course->title}}</h2>
                    <p>{{$course->description}}</p>
                </div>
            </div>
            <div class="course-show-detail-right">
                <a href="{{ route('courses.edit',$course) }}"><i class="bi bi-pencil-square"></i> Edit Basic Info</a>
            </div>
        </div>
        <hr>
        <div class="course-detail-bottom">
            <div class="course-detail-bottom-elements">
                <p><i class="bi bi-stopwatch" style="font-weight: bold;font-size: 20px;"></i></p>
                <p>Course Duration</p>
                <div><p>0m</p></div>
            </div>
            <div class="course-detail-bottom-elements">
                <p><i class="bi bi-easel" style="font-weight: bold;font-size: 20px;"></i></p>
                <p>Total Unit</p>
                <div><p>{{$course->units->count()}}</p></div>
            </div>
            <div class="course-detail-bottom-elements">
                <p><i class="bi bi-mortarboard-fill" style="font-weight: bold;font-size: 20px;"></i></p>
                <p>Course Level</p>
                <div><p>{{$course->level->name}}</p></div>
            </div>
            <div class="course-detail-bottom-elements">
                <p><i class="bi bi-clock-history" style="font-weight: bold;font-size: 20px;"></i></p>
                <p>Last Updated</p>
                <div><p>{{$course->updated_at->format('M d,Y')}}</p></div>
            </div>
            <div class="course-detail-bottom-elements">
                <p><i class="bi bi-patch-check-fill" style="font-weight: bold;font-size: 20px;"></i></p>
                <p>Certificate Of Completion</p>
                <div><p>{{$course->certificate == 1? 'Yes':'No'}}</p></div>
            </div>
        </div>
    </section>

    <h2 class="content-head">Course Content</h2>

    @foreach ($course->units as $unit)
        <section class="unit">
            <div class="unit-detail">
                <div>
                    <i class="bi bi-grip-vertical" style="font-size: 25px;color:grey;"></i>
                </div>
                <div class="unit-detail-info">
                    <h3>{{$unit->title}}</h3>
                    <p>{{$unit->description}}</p>
                </div>
            </div>
            <div class="unit-detail-right">
                <a href="{{ route('units.edit',['course'=>$course,'unit'=>$unit]) }}" class="unit-edit"><i class="bi bi-pencil-square"></i> Edit Section</a>
                <form action="{{ route('units.destroy',['course'=>$course,'unit'=>$unit]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                </form>
            </div>
        </section>
    @endforeach

@endsection
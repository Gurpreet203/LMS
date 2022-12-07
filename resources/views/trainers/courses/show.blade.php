@extends('layouts.main')

@section('content')
    <x-nav />
    @include('layouts.flashmessages')
    
    <section class="nav-bottom">
        <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><h4><a href="{{ route('courses') }}" style="text-decoration: none;">Courses</a></h4></li>
                <li class="breadcrumb-item active" aria-current="page" style="width: 600px;"><h4><a href="{{ route('courses.edit', $course)}}" style="text-decoration: none;">{{$course->title}}</a></h4></li>
            </ol>
        </div>
        <div>
            <a href="{{ route('units',$course) }}" class="btn btn-primary" id="createbtn">Add Unit</a>
        </div>
    </section>

    <section class="course-show">
        
        <div class="course-show-detail">
            
            <div class="course-show-detail-left">
                @if ($course->images)
                    <img src="{{asset('storage/'.$course->images->image)}}" alt="course-image">
                @else
                    <img src="{{asset('storage/images/default.jpg')}}" alt="course-image">
                @endif
                <div>
                    <h2>{{$course->title}}</h2>
                    <p>{{$course->description}}</p>
                </div>
            </div>
            <div class="course-show-detail-right">
                <a href="{{ route('courses.edit', $course) }}"><i class="bi bi-pencil-square"></i> Edit Basic Info</a>
            </div>
        </div>
        <hr>
        <div class="course-detail-bottom">
            <div class="course-detail-bottom-elements">
                <p><i class="bi bi-stopwatch" style="font-weight: bold;font-size: 20px;"></i></p>
                <p>Course Duration</p>
                <div><p>{{$course->units->sum('duration')}} m</p></div>
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
                <div><p>{{$course->certificate == true? 'Yes':'No'}}</p></div>
            </div>
        </div>
    </section>

    <h2 class="content-head">Course Content</h2>

    @foreach ($course->units as $unit)
        <section class="unit">
            <div class="unit-details">
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
                    <a href="{{ route('units.edit', [$course, $unit]) }}" class="unit-edit"><i class="bi bi-pencil-square"></i> Edit Section</a>
                    <form action="{{ route('units.destroy', [$course, $unit]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                    </form>
                </div>
            </div>
            <div>
                <h5 class="lessons-ui">Lessons <span>{{$unit->lessons->sum('duration')}} m</span></h5>
                @if ($unit->tests->count()>0)
                    @foreach ($unit->tests as $test)
                        <p class="lessons-detail">{{$test->name}} <span>{{$test->duration}} m</span></p>
                    @endforeach
                @endif
            </div>

        </section>
    @endforeach

@endsection
@extends('layouts.main')

@section('content')
    <x-nav/>
    @include('layouts.flashmessages')

    <section class="under-create-btn">
     
        <div class="right-dropdowns">
        
            <x-search  route="courses" placeholder="Search by Name or Description"/>
        
           
    </section>

    @if ($courses->count()>0)
        @foreach ($courses as $course)
            <section class="course-list">
                <div class="course-detail">
                    <div class="course-image">
                        <img src="{{asset('storage/'.$course->images->image)}}" alt="">
                    </div>
                    <div>
                        <a href="{{ route('my-courses.index') }}" class="category-badge">{{$course->category->name}}</a>
                        <h3>{{$course->title}}</h3>
                        <div class="course-created-details">
                            <p>Created By:<span>{{$course->user->name}}</span></p>
                            <p>Created On:<span>{{$course->created_at->format('F d,Y')}}</span></p>
                        </div>
                        <p>{{$course->description}}</p>
                        <div class="level-enrolled">
                            <p><i class="bi bi-bar-chart-fill"></i> {{$course->level->name}}</p>
                            <p><i class="bi bi-easel"></i> Enrolled</p>
                        </div>
                    </div>
                </div>
                <div class="course-options">
                    <p class="status-badge" @if($course->status->name=="Published")id="published" @elseif($course->status->name=="Archieved")id="archieved" @else id="draft" @endif>{{$course->status->name}}</p>
                    
                </div>
            </section>
        @endforeach 
    @else
        <h1 style="text-align: center;">No Course Exist</h1>      
    @endif
@endsection
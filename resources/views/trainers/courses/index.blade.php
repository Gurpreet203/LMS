@extends('layouts.main')

@section('content')
    <x-nav/>
    <x-nav-bottom heading="Courses" btn="Create New Course" route="courses.create"/>
    @include('layouts.flashmessages')
    <ul class="status-navigation">
        <li><a href="{{ route('courses') }}" @if(Request::url() == route('courses'))class='status-active' @endif>All Courses ({{$courses->count()}})</a></li>
        <li><a href="{{ route('courses') }}?status=3" class={{Request::url() == route('courses').'?filter=publish' ? 'status-active' : ''}}>Published ({{$courses->where('status_id', 3)->count()}})</a></li>
        <li><a href="{{ route('courses') }}?status=1" @if(Request::url() == route('courses').'?filter=draft') class='status-active' @endif>Draft ({{$courses->where('status_id', 1)->count()}})</a></li>
        <li><a href="{{ route('courses') }}?status=2" @if(Request::url() == route('courses').'filter=archieve') class='status-active' @endif>Archieve ({{$courses->where("status_id", 2)->count()}})</a></li>
    </ul>

    <hr style="margin-top: 10px;margin-left: 20px;margin-right: 20px;"/>

    <section class="under-create-btn">
     
        <div class="right-dropdowns">
        
            <x-search  route="courses" placeholder="Search by Name or Description"/>
        
            <div class="dropdown">
                <button class="btn-secondary right-dropdowns-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Category
                    <span class="dropdown-toggle "></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" id="scroll">
                    <li><a class="dropdown-item" href="{{ route('courses') }}">All</a></li>
                    @foreach ($categories as $category)
                        <li><a class="dropdown-item" href="{{ route('courses') }}?category={{ $category->id }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn-secondary right-dropdowns-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Level
                    <span class="dropdown-toggle "></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" id="scroll">
                    @foreach ($levels as $level)
                        <li><a class="dropdown-item" href="{{ route('courses') }}?level={{$level->id}}">{{$level->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn-secondary right-dropdowns-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Sort By
                <span class="dropdown-toggle "></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('courses') }}?sort=A-Z">Name A-Z</a></li>
            <li><a class="dropdown-item" href="{{ route('courses') }}?sort=Z-A">Name Z-A</a></li>
            <li><a class="dropdown-item" href="{{ route('courses') }}?sort=latest">Latest Created Date</a></li>
            <li><a class="dropdown-item" href="{{ route('courses') }}">Oldest Created Date</a></li>
            </ul>
        </div>
    </section>

    @if ($courses->count()>=1)
        @foreach ($courses as $course)
            <section class="course-list">
                <div class="course-detail">
                    <div class="course-image">
                        @if ($course->images)
                            <img src="{{asset('storage/'.$course->images->image)}}" alt="course-image">
                        @else
                            <img src="{{asset('storage/images/default.jpg')}}" alt="course-image">
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('courses') }}?category={{ $course->category->id }}" class="category-badge">{{$course->category->name}}</a>
                        <a href="{{ route('courses.show',$course) }}" class="title-link"><h3>{{$course->title}}</h3></a>
                        <div class="course-created-details">
                            <p>Created By:<span>{{$course->user->name}}</span></p>
                            <p>Created On:<span>{{$course->created_at->format('F d,Y')}}</span></p>
                        </div>
                        <p>{{$course->description}}</p>
                        <div class="level-enrolled">
                            <p><i class="bi bi-bar-chart-fill"></i> {{$course->level->name}}</p>
                            <p><i class="bi bi-easel"></i> {{$course->enrollments_count}} Enrolled</p>
                        </div>
                    </div>
                </div>
                <div class="course-options">
                    <p class="status-badge" @if($course->status->name=="Published")id="published" @elseif($course->status->name=="Archieved")id="archieved" @else id="draft" @endif>{{$course->status->name}}</p>
                    <div class="btn-group">
                        <button class="icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                            
                            <li class="drop-items">
                                <div class="drop-items-icon">
                                    <i class="bi bi-wrench-adjustable"></i>
                                    <a href="{{ route('courses.edit', $course) }}">Edit Course</a>
                                </div>
                            </li>
                            
                            <li class="drop-items">
                                <div class="drop-items-icon">
                                    <i class="bi bi-people-fill"></i>
                                    <a href="{{ route('courses.enroll', $course) }}">Users</a>
                                </div>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li class="drop-items">
                                @foreach ($statuses as $status)
                                    @if($course->status->name!=$status->name)
                                        <div class="drop-items-icon">
                                            <a href="{{ route('courses.status',$course)}}?statusUpdate={{$status->id}}">
                                            @if($status->name=='Published')
                                                <i class="bi bi-people-fill"></i>
                                            @elseif($status->name=='Archieved')
                                                <i class="bi bi-archive-fill"></i>
                                            @else
                                                <i class="bi bi-file-earmark-arrow-down-fill"></i>
                                            @endif
                                            {{$status->name}}</a>
                                        </div>
                                    @endif
                                @endforeach
                            </li>
                            <span class="text-danger">
                                @error('statusUpdate')
                                    {{$message}}
                                @enderror
                            </span>
                        </ul>
                    </div>
                </div>
            </section>
        @endforeach 
    @else
        <h1 style="text-align: center;">No Course Exist</h1>      
    @endif
@endsection
@extends('layouts.main')

@section('content')
    <x-nav/>
    @include('layouts.flashmessages')

    <div class="enroll">
        <div class="breadcrumbs-mine">
            <x-previousPageLink route="courses" name="Courses" current="{{$course->title}}"/>
        </div>

        <div>
            <form action="{{route('courses.enroll.store', $course)}}" method="POST">
                @csrf
                <select name="user_id" id="" class="form-select form-select-sm" multiple>
                    @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('user_id')
                        {{$message}}
                    @enderror
                </span>
                <input type="submit" value="Add">
            </form>
        </div>
    </div>
@endsection
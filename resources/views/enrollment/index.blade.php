@extends('layouts.main')

@section('content')
    <x-nav/>
    <div>
        <div class="breadcrumbs-mine">
            <x-previousPageLink route="courses" name="Courses" current="{{$course->title}}"/>
        </div>

        <div class="dropdown">
            <button class="btn-secondary right-dropdowns-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Add Users
                <span class="dropdown-toggle "></span>
            </button>

            @foreach ($users as $user)
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><input type="checkbox" class="dropdown-item" name="user_id" value="{{$user->id}}">{{$user->name}}</li>
                </ul>
            @endforeach
            
        </div>
            
    </div>
    @include('layouts.flashmessages')
@endsection
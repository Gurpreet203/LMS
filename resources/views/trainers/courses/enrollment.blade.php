@extends('layouts.main')

@section('content')
    <x-nav/>
    @include('layouts.flashmessages')

    <div class="enroll">
       
        <x-previousPageLink route="courses" name="Courses" current="{{$course->title}}"/>

        <div class="dropdown">
            <button class="btn-secondary right-dropdowns-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Add User
                <span class="dropdown-toggle "></span>
            </button>
            <ul class="dropdown-menu" style="padding: 10px;">
                
                @if ($users->count()>0)
                    <form action="{{  route('courses.enroll.store', $course) }}" method="POST">
                    @csrf
                        @foreach ($users as $user)
                            <li class="enroll-list">
                                <input type="checkbox" value="{{$user->id}}" name="user_ids[]" class="form-check-input">
                                <label for="user_ids[]" class="form-check-label">{{ $user->name }}</label>
                            </li>
                        @endforeach  
                        <input type="submit" class="btn btn-secondary btn-sm enrollBtn" value="Add" name="add">
                    </form>
                @else
                    <p style="color: grey;text-align:center;">No User Exist</p>                      
                @endif    
            </ul>
            <span class="text-danger">
                @error('user_ids')
                    {{$message}}
                @enderror
            </span>
        </div>
    </div>


    <div style="padding: 20px">
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Status</th>
            </tr>
            
            @if ($enrolledUsers->count()>0)
                @foreach ($enrolledUsers as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>
                            <form action="{{route('courses.enroll.destroy', ['course' => $course, 'user' => $user])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-secondary" value="Unenroll">
                            </form>
                        </td>
                    </tr>
                    
                @endforeach
            @else
                </table>
                <h3 style="text-align: center">No User Found</h3>
            @endif
        </table>
    </div>
@endsection
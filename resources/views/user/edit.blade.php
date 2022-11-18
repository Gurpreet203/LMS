@extends('layouts.main')

@section('content')

    <form action="{{ route('users.update',$user->slug) }}" method="POST" class="loginForm editForm">
        @csrf
        @method('PUT')
        <h1>Edit Account</h1>
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control form-control-sm">
        <span class="text-danger">
            @error('first_name')
                {{$message}}
            @enderror
        </span>
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" name="last_name" value="{{$user->last_name}}" class="form-control form-control-sm">
        <span class="text-danger">
            @error('last_name')
                {{$message}}
            @enderror
        </span>
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" value="{{$user->email}}" disabled class="form-control form-control-sm">
        
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" value="{{$user->phone}}" class="form-control form-control-sm">
        <span class="text-danger">
            @error('phone')
                {{$message}}
            @enderror
        </span>

        <label for="role_id" class="form-label">Role</label>
        <div class="mb-3">
            <select name="role_id" class="form-select">
                @foreach ($roles as $role)
                    <option value="{{$role['id']}}">{{$role['name']}}</option>
                @endforeach
            </select>
    
            <span class="text-danger">
                @error('role_id')
                    {{$message}}
                @enderror
            </span>
        </div>

       <div class="buttons">
        <input type="submit" value="Update" name="change">
        <a href="{{ route('users') }}">cancel</a>
       </div>
        
    </form>
@endsection
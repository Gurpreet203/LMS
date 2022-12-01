@extends('layouts.main')

@section('content')
    <x-nav />
    <div class="breadcrumbs-mine">
        <x-previousPageLink route="users" name="Users" current="Edit User"/>
    </div>
    <form action="{{ route('users.update',$user->slug) }}" method="POST" class="create-form">
        @csrf
        @method('PUT')
        <h1>Edit Account</h1>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control form-control-sm" required>
            <span class="text-danger">
                @error('first_name')
                    {{$message}}
                @enderror
            </span>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" value="{{$user->last_name}}" class="form-control form-control-sm" required>
            <span class="text-danger">
                @error('last_name')
                    {{$message}}
                @enderror
            </span>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" value="{{$user->email}}" disabled class="form-control form-control-sm">
        </div>
        
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" value="{{$user->phone}}" class="form-control form-control-sm" required>
            <span class="text-danger">
                @error('phone')
                    {{$message}}
                @enderror
            </span>
        </div>

        @if (Auth::user()->is_admin || Auth::user()->is_subadmin )
            <div class="mb-3">
                <label for="role_id" class="form-label">Role</label>
            
                <select name="role_id" class="form-select">
                    @foreach ($roles as $role)
                        <option value="{{$role->id}}" @if ($user->role_id == $role->id) selected @endif>{{$role->name}}</option>
                    @endforeach
                </select>
        
                <span class="text-danger">
                    @error('role_id')
                        {{$message}}
                    @enderror
                </span>
            </div>   
        @endif

        <button type="submit" name="update" class="btn btn-secondary">Update</button>
        <a href="{{ route('users') }}" class="btn btn-outline-secondary">Cancel</a>
        
    </form>
@endsection
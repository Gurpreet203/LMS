@extends('layouts.main')

@section('content')
    <x-nav />
    <div class="breadcrumbs-mine">
        <x-previousPageLink route="users" name="Users" current="Create User"/>
    </div>
    @include('layouts.flashmessages')
    <form action="{{ route('users.store') }}" method="POST" class="create-form">
        @csrf
        <h1>Create User</h1>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control form-control-sm" value="{{ old('first_name') }}" required>
            <span class="text-danger">
                @error('first_name')
                    {{$message}}
                @enderror
            </span>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control form-control-sm"  value="{{ old('last_name') }}" required>
            <span class="text-danger">
                @error('last_name')
                    {{$message}}
                @enderror
            </span>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}" required>
            <span class="text-danger">
                @error('email')
                    {{$message}}
                @enderror
            </span>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control form-control-sm"  value="{{ old('phone') }}" required>
            <span class="text-danger">
                @error('phone')
                    {{$message}}
                @enderror
            </span>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="male" class="form-control form-control-sm">
                <label class="form-check-label" for="flexRadioDefault1" class="form-label">
                Male
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2" value="female" class="form-control form-control-sm">
                <label class="form-check-label" for="flexRadioDefault2" class="form-label">
                Female
                </label>
            </div>

            <span class="text-danger">
                @error('gender')
                    {{$message}}
                @enderror
            </span>
        </div>

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

        <div class="mb-3">
            <button type="submit" value="save" name="save" class="btn btn-secondary">Invite User</button>
            <button type="submit" value="save_another" name="save" class="btn btn-secondary">Invite User & Invite Another</button>        
            <a href="{{ route('users') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
@endsection
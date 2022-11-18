@extends('layouts.main')

@section('content')
    <form action="{{ route('categories.store') }}" method="post" class="loginForm addUser">
        @csrf
        <h1>Create Category</h1>
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control form-control-sm" name="name" value="{{ old('name') }}">
        <span class="text-danger">
            @error('name')
                {{$message}}
            @enderror
        </span>
        <div class="buttons">
            <input type="submit" value="Create" name="addUser">
            <a href="{{ route('categories') }}">cancel</a>
        </div>
    </form>
@endsection
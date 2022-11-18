@extends('layouts.main')

@section('content')
    <form action="{{ route('categories.update',$category->name) }}" method="post" class="loginForm editForm">
        @csrf
        @method('PUT')
        <h1>Edit Category</h1>
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control form-control-sm" value="{{$category->name}}" required>
        <span class="text-danger">
            @error('name')
                {{$message}}
            @enderror
        </span>
        <div class="buttons">
            <input type="submit" value="Update" name="change">
            <a href="{{ route('categories') }}">cancel</a>
        </div>
    </form>
@endsection
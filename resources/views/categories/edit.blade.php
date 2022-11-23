@extends('layouts.main')

@section('content')
    <x-nav/>
    <div class="breadcrumbs-mine">
        <x-previousPageLink route="categories" name="Category" current="Edit Category"/>
    </div>
    <form action="{{ route('categories.update',$category) }}" method="post" class="create-form">
        @csrf
        @method('PUT')
        <h1>Edit Category</h1>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control form-control-sm" value="{{$category->name}}" required>
            <span class="text-danger">
                @error('name')
                    {{$message}}
                @enderror
            </span>
        </div>
       
        <input type="submit" value="Update" name="change" class="btn btn-secondary">
        <a href="{{ route('categories') }}" class="btn btn-outline-secondary">Cancel</a>
        
    </form>
@endsection
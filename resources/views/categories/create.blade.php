@extends('layouts.main')

@section('content')
    <x-nav/>
    <div class="breadcrumbs-mine">
        <x-previousPageLink route="categories" name="Categories" current="Create Category"/>
    </div>
    <form action="{{ route('categories.store') }}" method="post" class="create-form">
        @csrf
        <h1>Create Category</h1>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control form-control-sm" name="name" required value="{{ old('name') }}">
            <span class="text-danger">
                @error('name')
                    {{$message}}
                @enderror
            </span>
        </div>
        
        <input type="submit" value="Create" name="addUser" class="btn btn-secondary">
        <a href="{{ route('categories') }}" class="btn btn-outline-secondary">Cancel</a>
        
    </form>
@endsection
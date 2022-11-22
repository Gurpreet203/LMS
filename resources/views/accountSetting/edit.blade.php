@extends('layouts.main')

@section('content')
    <x-nav/>
    @include('layouts.flashmessages')
    <form action="{{ route('account.update') }}" method="POST" class="create-form">
        @csrf
        @method('PUT')
        <h1>Account & Settings</h1>
        <div class="row g-3">
          <div class="col-md-6 mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control form-control-sm" name="first_name" value="{{Auth::user()->first_name}}" required>
            <span class="text-danger">
              @error('first_name')
                  {{$message}}
              @enderror
          </span>
          </div>
          <div class="col-md-6 mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control form-control-sm" value="{{Auth::user()->last_name}}" required>
            <span class="text-danger">
              @error('last_name')
                  {{$message}}
              @enderror
          </span>
          </div>
        </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control form-control-sm" value="{{Auth::user()->email}}" disabled>
          </div>

          <button type="submit" class="btn btn-secondary">Update</button>
          <a href="{{route('account')}}" class="btn btn-outline-secondary">Cancel</a>
          
    </form>
@endsection
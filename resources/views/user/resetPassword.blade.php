@extends('layouts.main')

@section('content')
    @include('layouts.flashmessages')
    
    <form action="{{ route('reset-password.store' , $user->slug) }}" method="post" class="loginForm editForm">
        @method('PUT')
        @csrf
        <h1>Reset Password</h1>
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control form-control-sm" name="password">
        <span class="text-danger">
            @error('password')
                {{$message}}
            @enderror
        </span>

        <label for="confirm-password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control form-control-sm" name="confirm-password">
        <span class="text-danger">
            @error('confirm-password')
                {{$message}}
            @enderror
        </span>
        
        <div class="buttons">
            <input type="submit" value="Update" name="addPassword">
        </div>
    </form>
@endsection
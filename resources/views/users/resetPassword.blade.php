@extends('layouts.main')

@section('content')
    @include('layouts.flashmessages')
    
    <form action="{{ route('reset-password.store' , $user->slug) }}" method="post" class="loginForm editForm">
        @method('PUT')
        @csrf
        <h1>Reset Password</h1>
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control form-control-sm" name="password" required> 
        <x-error name='password' />

        <label for="confirm-password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control form-control-sm" name="confirm-password" required>
        <x-error name='confirm-password' />
        
        
        <button type="submit" class="btn btn-secondary">Update</button>
        <a href="{{ route('users') }}" class="btn btn-outline-secondary">Cancel</a>
        
    </form>
@endsection
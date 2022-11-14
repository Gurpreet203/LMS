<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>Document</title>
</head>
<body>
    @if (session('status'))
        <p class="alert alert-danger">{{session('status')}}</p>
    @endif
    <form action="{{ route('login') }}" method="POST" class="loginForm">
        @csrf
        <h1>Account Login</h1>
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control">
        <span class="text-danger">
            @error('email')
                {{$message}}
            @enderror
        </span>
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control">
        <span class="text-danger">
            @error('password')
                {{$message}}
            @enderror
        </span>
        <div>
            <input type="checkbox" name="remember">Remember me
            <a href="#">Forgot Password?</a>
        </div>
        <input type="submit" value="Log in" name="login">
    </form>
</body>
</html>
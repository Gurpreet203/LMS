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
    <section>

        @include('layouts.flashmessages')
            
            <form action="{{ route('forget-password.email') }}" method="post" class="loginForm">
                @csrf
                <h1>Forget Password</h1>
                <p class="mb-3 forget-password-text">Please enter your email address so we can send you email for change your password</p>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control form-control-sm" name="email" required placeholder="Email"> 
                    <span class="text-danger">
                        @error('email')
                            {{$message}}
                        @enderror
                    </span>
                </div>
                
                <button type="submit" class="btn btn-secondary">Send Email</button>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">Cancel</a>
                
            </form>
    </section>
</body>
</html>
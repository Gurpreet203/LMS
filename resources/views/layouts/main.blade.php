<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>LMS Laravel</title>
</head>
<body class="dashboard">
    <nav class="sidebar">
        <div>
            <img src="https://static.wixstatic.com/media/9e41e2_fb90fd7e41414c548936b423387b0554~mv2.png/v1/fill/w_538,h_108,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/SC%20Top%20Logo1.png" alt="loding">
        </div>
        <ul>
            
           @if (Auth::id() != 3)
            <a href="{{ route('dashboard') }}" id="{{ Request::url() == route('dashboard') ? 'hovereffect' : '' }}"><li><i class="bi bi-speedometer2"></i> Overview </li></a>
                
            <a href="{{ route('users') }}" id="{{ Request::url() == route('users') ? 'hovereffect' : '' }}"><li><i class="bi bi-people-fill"></i> Users </li></a>

            @if(Auth::user()->role_id!=4)
        
            <a href="{{ route('categories') }}" id="{{ Request::url() == route('categories') ? 'hovereffect' : '' }}"><li><i class="bi bi-list"></i> Categories</li></a>

            @endif
            
            <a href="{{ route('courses') }}" id="{{ Request::url() == route('courses') ? 'hovereffect' : '' }}"><li><i class="bi bi-files"></i> Courses</li></a>
            
            <a href="#"><li><i class="bi bi-bar-chart-fill"></i> Reports</li></a>

            @else
                <a href="{{ route('my-courses.index') }}" id="{{ Request::url() == route('my-courses.index') ? 'hovereffect' : '' }}"><li><i class="bi bi-files"></i> Course List</li></a>
            @endif

        </ul>
    </nav>
    <div>
        @yield('content')
    </div>
</body>
</html>
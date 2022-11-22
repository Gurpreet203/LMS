@props(['heading','btn','route'])

<section class="nav-bottom">
    <div>
        <h1>{{$heading}}</h1>
    </div>
    <div>
        <a href="{{ route($route) }}" class="btn btn-primary" id="createbtn">{{$btn}}</a>
    </div>
</section>
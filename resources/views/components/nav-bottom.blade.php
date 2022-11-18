@props(['heading','btn'])

<section class="nav-bottom">
    <div>
        <h2>{{$heading}}</h2>
    </div>
    <div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary" id="createbtn">Create {{$btn}}</a>
    </div>
</section>
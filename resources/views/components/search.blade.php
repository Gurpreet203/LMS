@props(['route','placeholder'])

<form action="{{ route($route) }}?{{request()->getQueryString()}}" method="get">
    <div class="d-flex">
        <input class="form-control" type="text" name="search" placeholder="{{$placeholder}}" value="{{request('search')}}">
        <i class="bi bi-search"></i>
    </div>
</form>
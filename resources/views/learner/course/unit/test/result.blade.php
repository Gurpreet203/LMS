@extends('layouts.main')

@section('content')
    <x-nav />
    <div style="text-align: right;margin: 1rem;">
        <a href="{{ route('my-courses.units.view', [$course, $unit]) }}" class="btn btn-primary">Go Back</a>
    </div>
        @if ($PassFail)
            <div class="result">
                <i class="bi bi-emoji-sunglasses"></i>
                <h2>
                    Yay ! You Passed The Test with {{$result}}% marks
                </h2>
            </div>
        @else
            <div class="result">
                <i class="bi bi-emoji-frown"></i>
                <h2>
                    Sorry ! You Failed In The Test with {{$result}}% marks
                </h2>
            </div>
        @endif
@endsection


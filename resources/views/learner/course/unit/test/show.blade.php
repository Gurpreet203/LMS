@extends('layouts.main')

@section('content')
    <x-nav />
        <div class="breadcrumbs-mine">
        <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><h4><a href="{{ route('courses') }}" style="text-decoration: none;">Course</a></h4></li>
                <li class="breadcrumb-item" ><a href="{{ route('my-courses.units.view', [$course, $unit]) }}" class="mine-bread">{{$unit->title}}</a></li>
                <li class="breadcrumb-item active mine" aria-current="page">Test Attempt</li>
            </ol>
        </div>
        </div>
    @include('layouts.flashmessages')
        <form action="{{ route('my-courses.units.test.submit', [$course, $unit, $test, $question]) }}" class="create-form" method="POST">
            @csrf
            <x-error name="answer" />
            
            <div class="mb-3">
                <label for="question" class="form-label">Question</label>
                <textarea name="question" id="" class="form-control" cols="30" rows="5" placeholder="Enter Question" disabled>{{$question->question}}</textarea>
            </div>
                
            <label for="options[]" class="form-label">Options</label>
            @php
               $i = 0; 
            @endphp
          
            @foreach ($question->options as $option)
                @php
                    $i++; 
                @endphp
                <div class="outter-input-radio">
                    <input type="text" name="options[]" id="options[]" class="form-control mb-3" placeholder="option" value="{{$option->option}}" disabled>

                    <input type="radio" name="answer" value="{{$option->id}}" id="radio">
                        
                </div>

            @endforeach
            <button type="submit" name='submit' value='submit' class="btn btn-secondary">Submit Answer</button>
        </form>

@endsection


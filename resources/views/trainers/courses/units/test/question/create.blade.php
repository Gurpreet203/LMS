@extends('layouts.main')

@section('content')
    <x-nav />
    <div class="course-content">
        <div class="breadcrumbs-mine">
            <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" ><h4><a href="{{ route('courses') }}" style="text-decoration: none;">Course</a></h4></li>
                    <li class="breadcrumb-item" ><a href="{{ route('test.edit', [$course, $unit, $test]) }}" class="mine-bread">{{$test->name}}</a></li>
                    <li class="breadcrumb-item active mine" aria-current="page">Add Questions</li>
                </ol>
            </div>
        </div>

        <div style="margin: 20px">
            <a href="{{route('courses.show', $course)}}" class="btn btn-primary">Go To Course Content</a>
        </div>
    </div>
    @include('layouts.flashmessages')
        <form action="{{ route('question.store', [$course, $unit, $test]) }}" class="create-form" method="POST">
            @csrf
            <x-error name="options.*" />
            <x-error name="options" />
            <div class="mb-3">
                <label for="question" class="form-label">Question</label>
                <textarea name="question" id="" class="form-control" cols="30" rows="5" placeholder="Enter Question">{{old('question')}}</textarea>
                <x-error name="question"/>
            </div>
            <div class="mb-2 add-item">
                <a href="#" id="add_more_fields"><i class="bi bi-plus"></i> Add More Options</a>
            </div>
            <div class="mb-3">
                <label for="options[]" class="form-label">Options</label>
                <div class="outter-input-radio">
                    <input type="text" 
                        name="options[]"
                        id="options[]" 
                        class="form-control mb-3" 
                        placeholder="option"
                        value="{{old('options.input.0')}}"
                    >
                    <input type="radio" name="radio" value="1" id="radio">
                </div>
                <x-error name="options.0" />

                <x-error name="radio" />   

                <div class="outter-input-radio">
                    <input type="text" name="options[]" id="options[]" class="form-control mb-3" placeholder="option" value="{{old('options.input.1')}}">
                       
                    <input type="radio" name="radio" value="2" id="radio">
                </div>
                <x-error name="options.1" />
                <x-error name="radio" />


                <div class="outter-input-radio">
                    <div id="input-field" style="width: 92%"></div>
                    <div class="radio-input" id="radio-input"></div>
                </div>
                
            </div>

            <button type="submit" value="save" name="save" class="btn btn-secondary">Save</button>
            <button type="submit" value="save-another" name="save" class="btn btn-secondary">Save & Add Another</button>
            <a href="{{ route('test.edit',[$course, $unit, $test]) }}" class="btn btn-outline-secondary">Cancel</a>
            
        </form>


    <script type="text/javascript">
        var options = document.getElementById('radio-input');
        var input_filed = document.getElementById('input-field');
        var radio = document.querySelectorAll('#radio');
        var add_more_fields = document.getElementById('add_more_fields');

        add_more_fields.onclick = function(){

            let count = radio.length + 1;

            var newField = document.createElement('input');
            newField.setAttribute('type','text');
            newField.setAttribute('name','options[]');
            newField.setAttribute('id','options[]');
            newField.setAttribute('class','form-control mb-3');
            newField.setAttribute('placeholder','option');

            var newRadio = document.createElement('input');
            newRadio.setAttribute('type','radio');
            newRadio.setAttribute('name','radio');
            newRadio.setAttribute('value', count)
            newRadio.setAttribute('class','form-check mb-3');
            newRadio.setAttribute('id','radio');

            input_filed.appendChild(newField);
            options.appendChild(newRadio);
        
        }
</script>

@endsection
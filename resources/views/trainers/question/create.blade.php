@extends('layouts.main')

@section('content')
    <x-nav />
    <div class="breadcrumbs-mine">
        <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><h4><a href="{{ route('courses') }}" style="text-decoration: none;">Course</a></h4></li>
                <li class="breadcrumb-item" ><a href="{{ route('courses.show', $course) }}" class="mine-bread">{{$course->title}}</a></li>
                <li class="breadcrumb-item" ><a href="{{ route('units.edit', [$course,$unit]) }}" class="mine-bread">{{$unit->title}}</a></li>
                <li class="breadcrumb-item" ><a href="{{ route('test.edit', [$course,$unit,$test]) }}" class="mine-bread">{{$test->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="width: 600px;"><h4>Add Questions</h4></li>
            </ol>
        </div>
    </div>
    @include('layouts.flashmessages')
        <form action="{{ route('question.store', [$course, $unit, $test]) }}" class="create-form" method="POST">
            @csrf
            <div class="mb-3">
                <label for="question" class="form-label">Question</label>
                <textarea name="question" id="" class="form-control" cols="30" rows="5" placeholder="Enter Question">{{old('question')}}</textarea>
                <span class="text-danger">
                    @error('question')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <div class="mb-2 add-item">
                <a href="#" id="add_more_fields"><i class="bi bi-plus"></i> Add More</a>
            </div>
            <div class="mb-3">
                <label for="options[]" class="form-label">Options</label>
                <div class="radio-input">
                        <input type="radio" name="radio" value="1">
                    
                        <input type="text" name="options[]" id="options[]" class="form-control mb-3" placeholder="option">
                            <span class="text-danger">
                                @error('options[]')
                                    {{$message}}
                                @enderror
                            </span>
                    
                </div>
                <div class="radio-input">
                    
                        <input type="radio" name="radio" value="2">
                   
                        <input type="text" name="options[]" id="options[]" class="form-control mb-3" placeholder="option">
                            <span class="text-danger">
                                @error('options[]')
                                    {{$message}}
                                @enderror
                            </span>
                    
                </div>

                <div class="radio-input" id="radio-input">
                    <div id="radio"></div>
                    <div class="mb-3" id="container"></div>
                </div>
                
            </div>
           
            <div id="radio"></div>
            <button type="submit" value="save" name="save" class="btn btn-secondary">Save</button>
            <button type="submit" value="save-another" name="save" class="btn btn-secondary">Save & Add Another</button>
            <a href="{{ route('test.edit',[$course, $unit, $test]) }}" class="btn btn-outline-secondary">Cancel</a>
            
        </form>

         <h1 style="margin-left: 20px">Questions</h1>

    <div>
        @foreach ($test->questions as $question)
        <section class="unit">
            <div class="unit-detail">
                <div>
                    <i class="bi bi-grip-vertical" style="font-size: 25px;color:grey;"></i>
                </div>
                <div class="unit-detail-info">
                    <h3>{{$question->question}}</h3>
                </div>
            </div>
            <div class="unit-detail-right">
                <a href="{{ route('question.edit',[$course, $unit, $test, $question]) }}" class="unit-edit" style="width: 30px"><i  style="font-size: 18px;" class="bi bi-pencil-square"></i></a>
                <form action="{{ route('question.destroy',[$question]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </section>
    @endforeach
    </div>

    <script type="text/javascript">
        var options = document.getElementById('radio-input');
        var radio = document.getElementById('radio');
        var add_more_fields = document.getElementById('add_more_fields');

        add_more_fields.onclick = function(){
            var i =3;
        var newField = document.createElement('input');
        newField.setAttribute('type','text');
        newField.setAttribute('name','options[]');
        newField.setAttribute('id','options[]');
        newField.setAttribute('class','form-control mb-3');
        newField.setAttribute('placeholder','option');

        var newRadio = document.createElement('input');
        newRadio.setAttribute('type','radio');
        newRadio.setAttribute('name','radio');
        newRadio.setAttribute('value', i)
        newField.setAttribute('class','form-check mb-3');

        options.appendChild(newRadio);
        options.appendChild(newField);
        i++;
        }

        function my_name()
        {
            document.getElementById("right_option").value= document.getElementById('options[]').value;
        }
</script>

@endsection



        <div>
            <form action="{{route('my-courses.store')}}" method="POST">
                @csrf
                <select name="course_id" id="" class="form-select form-select-sm" multiple>
                    @foreach ($courses as $course)
                        <option value="{{$course->id}}">{{$course->title}}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('course_id')
                        {{$message}}
                    @enderror
                </span>
                <input type="submit" value="Add">
            </form>
        </div>
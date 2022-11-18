@extends('layouts.main')

@section('content')
    <main>
        @include('layouts.nav')
        <section class="nav-bottom">
            <div>
                <h2>Categories</h2>
            </div>
            <div>
                <a href="{{ route('categories.create') }}" class="btn btn-primary" id="createbtn">Create Category</a>
            </div>
        </section>

        <section class="under-create-btn">
            <form action="{{ route('categories') }}?{{request()->getQueryString()}}" method="get">
                <div class="d-flex">
                    <input class="form-control" type="text" name="search" placeholder="Search by Name">
                    <i class="bi bi-search"></i>
                </div>
            </form>
            <div class="right-dropdowns">
                <div class="dropdown">
                    <button class="btn-secondary dropdown-toggle right-dropdowns-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Latest Created Date
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{ route('categories') }}?date=latest">Latest Created Date</a></li>
                        <li><a class="dropdown-item" href="{{ route('categories') }}">Oldest Created Date</a></li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="side-section">
            
            @include('layouts.flashmessages')
        
            <table class="table" cellspacing=0>
                <tr>
                <th>Name</th>
                <th>CREATED BY</th>
                <th>COURSES</th>
                <th>CREATED DATE</th>
                <th>Status</th>
                <th></th>
                </tr>
                @if ($categories->count()>=1)
                    @foreach ($categories as $category)
                        
                        <tr>
                            <td>
                                {{$category->name}}
                            </td>

                            <td>
                                {{$category->user->name}}
                                <span>{{$category->user->email}}</span>
                            </td>

                            <td></td>
                            
                            
                            <td>
                                {{$category->created_at->format('M d,Y')}}
                                <span>{{$category->created_at->format('h:i A')}}</span>
                            </td>
                            
                            <td>
                                @if($category->status)
                                    <span class="badge rounded-pill text-bg-success">Active</span>
                                @else
                                    <span class="badge rounded-pill text-bg-danger">Inactive</span>
                                @endif
                            </td>

                                <td>
                                <div class="btn-group">
                                    <button class="icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                    <li>
                                            @if($category->status)
                                                
                                                    <form action="{{ route('categories.status',$category) }}" method="post">
                                                        @csrf
                                                        <div class="drop-items-icon">
                                                            <i class="bi bi-slash-circle"></i>
                                                            <input type="submit" value="Deactive" name="deactive" class="drop-items">
                                                        </div>
                                                    </form>
                                            @else
                                                
                                                <form action="{{ route('categories.status',$category) }}" method="post">
                                                    @csrf
                                                    <div class="drop-items-icon">
                                                        <i class="bi bi-circle"></i>
                                                        <input type="submit" value="Active" name="active" class="drop-items">
                                                    </div>
                                                </form>  
                                            @endif
                                        </li>
                                        
                                        <li class="drop-items">
                                            <div class="drop-items-icon">
                                                <i class="bi bi-pencil-square"></i>
                                                <a href="{{ route('categories.edit',$category) }}">Edit</a>
                                            </div>
                                            
                                        </li>
                                        
                                        <li>
                                            
                                            <form action="{{ route('categories.delete',$category) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <div class="drop-items-icon">
                                                    <i class="bi bi-trash"></i>
                                                    <input type="submit" value="Delete" name="delete" class="drop-items">
                                                </div>
                                            </form>  
                                        </li>
                                    </ul>
                                </div>
                            </td> 

                            
                        
                        </tr>
                    @endforeach

                @else
                    </table>
                    <h3 class="text-center">No data found </h3>
                @endif
            
            </table>

            {{ $categories->links() }}
        </section>
        
    </main>
@endsection
@extends('layouts.main')
@section('content')
    @include('layouts.nav')

    <main>

        <section class="nav-bottom">
            <div>
                <h2>Users</h2>
            </div>
            <div>
                <a href="{{ route('users.create') }}" class="btn btn-primary" id="createbtn">Create User</a>
            </div>
        </section>

        <section class="under-create-btn">
            <form action="{{ route('users') }}?{{request()->getQueryString()}}" method="get">
                <div class="d-flex">
                    <input class="form-control" type="text" name="search" placeholder="Search by Name or Email" value= {{ request('search') }}>
                    <i class="bi bi-search"></i>
                </div>
            </form>
            <div class="right-dropdowns">
                <div class="dropdown">
                    <button class="btn-secondary dropdown-toggle right-dropdowns-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        All User Type
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{ route('users') }}">All</a></li>
                        @foreach ($roles as $role)
                            <li><a class="dropdown-item" href="{{ route('users') }}?role={{ $role->id }}">{{ $role->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn-secondary dropdown-toggle right-dropdowns-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Latest Created Date
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" href="{{ route('users') }}?date=latest">Latest Created Date</a></li>
                      <li><a class="dropdown-item" href="{{ route('users') }}">Oldest Created Date</a></li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="side-section">
            
            @include('layouts.flashmessages')

            <table class="table"cellspacing=0>
                <tr>
                <th>USER NAME</th>
                <th>TYPE OF USER</th>
                <th>COURSES</th>
                <th>CREATED DATE</th>
                <th>Status</th>
                <th></th>
                </tr>
                @if ($users->count()>=1)
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{$user->name}}
                                <span>{{$user->email}}</span>
                            </td>
                        
                            <td>
                                {{$user->role->name}}
                            </td>

                            <td></td>
                            <td>
                                {{ $user->created_at->format('M d,Y') }}
                                <span>{{ $user->created_at->format('h:i A') }}</span>
                            </td>

                            <td>
                                @if($user->status)
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
                                            @if($user->status)
                                                <form action="{{ route('users.status',$user) }}" method="post">
                                                    @csrf
                                                    <div class="drop-items-icon">
                                                        <i class="bi bi-slash-circle"></i>
                                                        <input type="submit" value="Deactive" name="deactive" class="drop-items">
                                                    </div>
                                                </form>
                                            @else
                                                <form action="{{ route('users.status',$user) }}" method="post">
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
                                                <a href="{{ route('users.edit', $user) }}">Edit</a>
                                            </div>
                                        </li>
                                        
                                        <li>
                                            <form action="{{ route('reset-password', $user) }}" method="post">
                                                @csrf
                                                <div class="drop-items-icon">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                    <input type="submit" value="Reset Password" name="reset" class="drop-items">
                                                </div>
                                            </form>
                                        </li>

                                        <li>
                                            <form action="{{ route('users.delete', $user) }}" method="post">
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
                    <h3 class="text-center">No Record Found</h3>
                @endif
            </table>

            {{ $users->links() }}

        </section>
    </main>
@endsection
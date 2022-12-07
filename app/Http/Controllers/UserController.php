<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    
    public function index()
    {    
        
        $users = User::with('role')
            ->withCount('enrollments')
            ->latest()
            ->visibleTo()
            ->search(request(['search', 'role', 'sort']))
            ->simplePaginate(6);

        return view('users.index', [
            'users' => $users,
            'roles' => Role::list()
        ]);
    }

    public function create()
    {
        return view('users.create', [
            'roles' => Role::list(),
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
                'first_name' => 'required|min:3|max:255|alpha',
                'last_name' => 'required|min:3|max:255|alpha',
                'phone' => 'required|numeric|min:2|digits:10',
                'gender' => 'required',
                'email' => 'required|email:rfs,dns',
                'role_id' => ['required',
                    Rule::in(
                            Role::list()
                                ->pluck('id')
                                ->toArray()
                        ),
                    ]
                 ],
            );

        $attributes +=[
            'created_by' => Auth::id(),
        ];

        $user = User::where('email', $attributes['email'])->withTrashed()->first();
        
        if ($user)
        {
            if ($user->deleted_at != null)
            {
                $user->restore();
                $user->update(array_merge($attributes, [
                    'password' => null,
                    'status' => 0,
                    'email_status' => 0
                ]));             
            }
        }
        else
        {
            $user = User::create($attributes);            
        }
        
        Notification::send($user, new UserNotification(Auth::user()));

        if($request['save'] == 'save')
        {
            return to_route('users.edit', $user)
                ->with('status', 'Successfully Created');
        }

        return back()->with('status', 'Successfully Created');
    }

    public function edit(User $user)
    { 
        $this->authorize('update', $user);

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::list()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $attributes = $request->validate([
            'first_name'=>'required|min:3|max:255|alpha',
            'last_name' => 'required|min:3|max:255|alpha',
            'phone' => 'required|numeric|min:2|digits:10',
            'role_id' => ['required',
                    Rule::in(
                            Role::list()
                                ->pluck('id')
                                ->toArray()
                        )
                    ]
            ]
        );

        $user->update($attributes);

        return to_route('users')->with('status', 'Successfully Updated');        
    }

    public function delete(User $user)
    {
        $this->authorize('delete', $user);

        $deleted = $user->delete();

        if($deleted) // exception throw
        {
            return back()->with('status', 'Successfully deleted');
        }
        else
        {
            return back()->with('error', 'Something Went Wrong In Deletion');
        }

    }
}

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
        
        $users = User::latest()->search(request(['search', 'role', 'date']))->simplePaginate(6);

        return view('user.index',[
            'users' => $users,
            'roles' => Role::list()
        ]);
    }

    public function create()
    {
        return view('user.create', [
            'roles' => Role::list(),
        ]);
    }

    public function store(Request $request)
    {
        $roles = Role::list();

        $roles =$roles->pluck('id')->toArray();
        
        $attributes = $request->validate([
                'first_name' => 'required|min:3|max:255|string',
                'last_name' => 'required|min:3|max:255|string',
                'phone' =>'required|numeric|min:2',
                'gender' =>'required|string',
                'email' =>'required|email:rfs,dns|unique:users',
                'role_id' => ['required',
                    Rule::in(array_values($roles))
                ]
            ]
        );
       
        // $slug = User::;

        $attributes +=[
            // 'slug' => $slug,
            'created_by' => Auth::id(),
        ];

        $user = User::where( 'email' ,$attributes['email'] )->withTrashed()->first();
        
        if ($user)
        {
            if ($user->deleted_at != null)
            {
                $user->restore();
                $user->update( array_merge($attributes, [
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
            return to_route('users')->with('status', 'Successfully Created');
        }

        return back()->with('status','Successfully Created');
    }

    public function edit(User $user)
    { 
        return view('user.edit', [
            'user' => $user,
            'roles' => Role::list()
        ]);
    }

    public function update(Request $request , User $user)
    {
        $roles = Role::list();

        $roles =$roles->pluck('id')->toArray();

        $attributes = $request->validate([
            'first_name'=>'required|min:3|max:255|string',
            'last_name' => 'required|min:3|max:255|string',
            'phone' =>'required|numeric|min:2',
            'role_id' => ['required',
                    Rule::in(array_values($roles))
                ]
            ]
        );

        $user->update($attributes);

        return to_route('users')->with('status','Successfully Updated');        
    }

    public function delete(User $user)
    {
        $deleted = $user->delete();

        if($deleted) // exception throw
        {
            return back()->with('status','Successfully deleted');
        }
        else
        {
            return back()->with('error','Something Went Wrong In Deletion');
        }

    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $attributes = $request->validate([
                'email'=>'required|email',
                'password'=>'required|min:5|max:255'
            ]
        );

        $user = User::where('email', $attributes['email'])->first();

        if ($user)
        {
            if ($user->status==1 && Auth::attempt($attributes))
            {
                $user->update([
                    'email_status' => 1
                ]);
            }
            
            return back()->with('status','You are Inactive user Or your email or password is incorrect');
        }

        return back()->with('error','User Not Found please Make A Account First');
    }

    public function logout()
    {
        Auth::logout();
        
        return to_route('login');
    }

}

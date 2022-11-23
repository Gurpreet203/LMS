<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ForgetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class ForgetPasswordController extends Controller
{
    public function index()
    {
        return view('forgetPassword.index');
    }

    public function confirmation(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|email:rfs,dns|max:255|min:5'
        ]);

        $user = User::where('email', $attributes['email'])->first();

        if($user)
        {
            Notification::send($user, new ForgetPasswordNotification);

            return back()->with('status', 'Please Check Your Email For Change Password');
        }

        return back()->with('error', 'Please Enter Valid Email');
    }

    public function edit(User $user)
    {
        return view('forgetPassword.create',[
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $attributes = $request->validate([
            'password' => 'required|min:8|max:255',
            'confirm-password' => 'required|same:password'
        ]);

        $user->update([
            'password' => Hash::make($attributes["password"])
        ]);

        return to_route('login')->with('status', 'Password updated successfully Please login with new Password');
    }
}

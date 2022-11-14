<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function index(User $user)
    {
        return view('user.resetPassword', [
            'user' => $user
        ]);
    }

    public function store(Request $request, User $user)
    {
        $attributes = $request->validate([
            'password' => 'required|min:8',
            'confirm-password' => 'required|min:8|same:password'
        ]);

        $user->update([
            'password' => bcrypt($attributes['password'])
        ]);

        Notification::send($user, new ResetPasswordNotification(Auth::user(), $attributes['password']));  // need to correct in other way.

        return to_route('users')->with('status', 'Password Changed');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserStatusController extends Controller
{
    public function status(User $user)
    {
        if ($user->status)
        {
            $user->update([
                'status' => 0
            ]);
        }
        else
        {
            $user->update([
                'status' => 1
            ]);
        }

        // if (!$update)
        // {
        //     return redirect()->route('users')->with('error','Something Went Wrong');
        // }

        return to_route('users');
    }
}

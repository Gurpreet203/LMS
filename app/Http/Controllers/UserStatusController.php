<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserStatusController extends Controller
{
    public function __invoke(User $user)
    {
       
        if ($user->status)
        {
            $user->update([
                'status' => User::INACTIVE,
                'email_status' => User::INACTIVE
            ]);
        }
        
        else
        {
            $user->update([
                'status' => User::ACTIVE,
                'email_status' => User::ACTIVE
            ]);
        }
        
        return to_route('users');
    }
}

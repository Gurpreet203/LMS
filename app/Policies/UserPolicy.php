<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, User $currUser)
    {
        return $user->id === $currUser->created_by;
    }

    public function delete(User $user, User $currUser)
    {
        return $user->id === $currUser->created_by;
    }
}

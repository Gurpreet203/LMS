<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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

    public function update(User $user, Category $category)
    {
        return $user->id === $category->created_by;
    }

    public function delete(User $user, Category $category)
    {
        return $user->id === $category->created_by;
    }
}

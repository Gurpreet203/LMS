<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use App\Policies\CategoryPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        Gate::define('notEmployee', function(User $user){
            return $user->role_id != Role::EMPLOYEE;
        });

        Blade::if('notEmployee', function () {
            return request()->user()->can('notEmployee');
        });
    }
}

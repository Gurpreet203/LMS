<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Category;
use App\Models\Course;
use App\Models\Question;
use App\Models\Template;
use App\Models\Test;
use App\Models\Unit;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\CoursePolicy;
use App\Policies\QuestionPolicy;
use App\Policies\TemplatePolicy;
use App\Policies\TestPolicy;
use App\Policies\UnitPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',

        User::class => UserPolicy::class,
        Category::class => CategoryPolicy::class,
        Course::class => CoursePolicy::class,
        Unit::class => UnitPolicy::class,
        Test::class => TestPolicy::class,
        Question::class => QuestionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

<?php

use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryStatusController;
use App\Http\Controllers\CourseControllerr;
use App\Http\Controllers\CourseEnrollmentController;
use App\Http\Controllers\CourseStatusController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SetPasswordController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserStatusController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    if (Auth::check()) {

        if (Auth::user()->is_employee) {

            return to_route('my-courses.index');
        }

        return to_route('dashboard');
    }

    return to_route('login');
});
    
Route::controller(LoginController::class)->group(function(){

    Route::get('/login', 'index')->name('login');

    Route::post('/login', 'login');

    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

Route::controller(ForgetPasswordController::class)->group(function(){
        
    Route::get('/forget-password', 'index')->name('forget-password');

    Route::post('/forget-password/email-send', 'confirmation')->name('forget-password.email');

    Route::get('/forget-password/{user:slug}/new-password', 'edit')->name('forget-password.change');

    Route::put('/forget-password/{user:slug}/new-password', 'update')->name('forget-password.update');

});


Route::middleware(['auth'])->group(function() {

    Route::controller(AccountSettingController::class)->group(function() {

        Route::get('/account/setting', 'edit')->name('account');

        Route::put('/account/setting', 'update')->name('account.update');

    });
    
    Route::controller(OverviewController::class)->group(function(){

        Route::get('/dashboard', 'index')->name('dashboard');

    });

    Route::controller(UserController::class)->group(function() {

        Route::get('/users', 'index')->name('users');
    
        Route::get('/users/create', 'create')->name('users.create');

        Route::post('/users/store', 'store')->name('users.store');

        Route::get('/users/{user:slug}/edit', 'edit')->name('users.edit');

        Route::put('/users/{user:slug}/update', 'update')->name('users.update');

        Route::delete('/users/{user:slug}/delete', 'delete')->name('users.delete');

    });

    Route::post('/users/{user:slug}/status', UserStatusController::class)->name('users.status');

    Route::controller(CategoryController::class)->group(function() {

        Route::get('/categories', 'index')->name('categories');  

        Route::get('/categories/create', 'create')->name('categories.create');
    
        Route::post('/categories/create', 'store')->name('categories.store'); 
    
        Route::get('/categories/{category:slug}/edits', 'edit')->name('categories.edit');  
    
        Route::put('/categories/{category:slug}/update', 'update')->name('categories.update'); 
    
        Route::delete('/categories/{category:slug}/delete', 'delete')->name('categories.delete'); 

    });
    
    Route::post('/categories/{category:slug}/status', CategoryStatusController::class)->name('categories.status');

    Route::controller(SetPasswordController::class)->group(function(){

        Route::get('/{user:slug}/set-password', 'index')->name('set-password');

        Route::post('/{user:slug}/set-password', 'store')->name('set-password.store');

    });

    Route::controller(ResetPasswordController::class)->group(function(){

        Route::post('/{user:slug}/reset-password', 'index')->name('reset-password');

        Route::put('/{user:slug}/reset-password', 'store')->name('reset-password.store');

    });

    Route::controller(CourseControllerr::class)->group(function(){

        Route::get('/courses', 'index')->name('courses');

        Route::get('/courses/create', 'create')->name('courses.create');

        Route::post('/courses/store', 'store')->name('courses.store');

        Route::get('/courses/{course:slug}/edit', 'edit')->name('courses.edit');

        Route::put('/courses/{course}/update', 'update')->name('courses.update');

        Route::get('/courses/{course:slug}', 'show')->name('courses.show');

    });

    Route::get('/courses/{course}/status', CourseStatusController::class)->name('courses.status');

    Route::controller(UnitController::class)->group(function(){

        Route::get('/courses/{course:slug}/units/create', 'create')->name('units');

        Route::post('/courses/{course}/units/store', 'store')->name('units.store');

        Route::get('/courses/{course:slug}/units/{unit:slug}/edit', 'edit')->name('units.edit');

        Route::put('/courses/{course:slug}/units/{unit}/update', 'update')->name('units.update');

        Route::delete('/courses/{course:slug}/units/{unit}/destroy', 'destroy')->name('units.destroy');

    });
    
    Route::controller(EnrollmentController::class)->group(function(){

        Route::get('/courses/{course:slug}/users/enroll', 'index')->name('courses.enroll');

        Route::post('/courses/{course:slug}/users/enroll/store', 'store')->name('courses.enroll.store');

        Route::delete('/courses/{course}/{user}/destroy', 'destroy')->name('courses.enroll.destroy');
    });

    Route::controller(CourseEnrollmentController::class)->group(function(){

        Route::get('users/{user:slug}/enroll-courses', 'index')->name('enroll-courses.create');

        Route::post('users/{user:slug}/enroll-courses', 'store')->name('enroll-courses.store');

        Route::delete('users/{user}/{course}/destroy', 'destroy')->name('enroll-courses.destroy');

    });

    Route::controller(TestController::class)->group(function(){

        Route::get('/courses/{course:slug}/units/{unit:slug}/test/create', 'create')->name('test.create');

        Route::post('/courses/{course:slug}/units/{unit:slug}/test/store', 'store')->name('test.store');

        Route::get('/courses/{course:slug}/units/{unit:slug}/test/{test}/edit', 'edit')->name('test.edit');

        Route::put('/courses/units/test/{test}/update', 'update')->name('test.update');

        Route::delete('/courses/units/test/{test}/destroy', 'destroy')->name('test.destroy');
    });

    Route::controller(QuestionController::class)->group(function(){

        Route::get('/courses/{course:slug}/units/{unit:slug}/test/{test}/create', 'create')->name('question.create');

        Route::post('/courses/{course:slug}/units/{unit:slug}/test/{test}/store', 'store')->name('question.store');

        Route::get('/courses/{course:slug}/units/{unit:slug}/test/{test}/question/{question}/edit', 'edit')->name('question.edit');

        Route::put('/courses/unit/test/question/{question}/update', 'update')->name('question.update');

        Route::delete('/courses/unit/test/{question}/delete', 'destroy')->name('question.destroy');

    });

    Route::controller(EmployeeController::class)->group(function(){

        Route::get('/my-courses', 'index')->name('my-courses.index');
        
    });

});
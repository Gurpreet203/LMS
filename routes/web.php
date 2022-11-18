<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryStatusController;
use App\Http\Controllers\CourseControllerr;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SetPasswordController;
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

            return redirect('/my-courses.index');
        }

        return redirect('/dashboard');
    }

    return redirect('/login');
});

Route::controller(LoginController::class)->group(function(){

    Route::get('/login', 'index')->name('login');

    Route::post('/login', 'login');

    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

Route::middleware(['auth'])->group(function() {
    
    Route::controller(RouteController::class)->group(function(){

        Route::get('/dashboard', 'index')->name('dashboard');

        Route::get('/employee', 'employee')->name('employee');

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

    });
    
});
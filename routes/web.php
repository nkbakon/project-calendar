<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\DepartmentController;
use \App\Http\Controllers\ProjectController;
use \App\Http\Controllers\CalendarController;
use \App\Http\Controllers\PasswordController;
use \App\Http\Controllers\TaskController;
use \App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function() {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('calendar', CalendarController::class)->except('show');
    Route::get('calendar/personal', [CalendarController::class, 'personal'])->name('calendar.personal');

    Route::resource('departments', DepartmentController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('todo', TodoController::class);
    Route::get('projects/{project}/view', [ProjectController::class, 'view'])->name('projects.view');
    Route::get('tasks/{task}/view', [TaskController::class, 'view'])->name('tasks.view');

    Route::group(['middleware' => ['admin']], function() {    
        Route::resource('users', UserController::class);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    Route::put('/profile', [PasswordController::class, 'update'])->name('password.update');
});
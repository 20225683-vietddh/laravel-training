<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DemoController;

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
    return redirect()->route('users.index');
});

// Demo Dashboard Route
Route::get('/demo-dashboard', [DemoController::class, 'dashboard'])->name('demo.dashboard');

// User Management Routes
Route::resource('users', UserController::class);
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

// Task Management Routes  
Route::resource('tasks', TaskController::class);

// API Routes for demonstration
Route::prefix('api')->group(function () {
    // UserController - Eloquent ORM với eager loading
    Route::get('/users-with-relations', [UserController::class, 'getUsersWithRelations']);
    
    // TaskController - Query Builder với JOIN
    Route::get('/tasks-with-users', [TaskController::class, 'getTasksWithUsers']);
    Route::get('/task-stats-by-user', [TaskController::class, 'getTaskStatsByUser']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('lang/{lang}', [\App\Http\Controllers\LanguageController::class, 'changeLanguage'])->name('lang');

require __DIR__.'/auth.php';

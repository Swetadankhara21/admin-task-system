<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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

// Public login routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
// Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes for all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my');
    Route::get('/user', [TaskController::class, 'user'])->name('user');
    Route::get('/user-task', [TaskController::class, 'user_task'])->name('user-task');
    Route::post('/tasks/{task}/done', [TaskController::class, 'markDone'])->name('tasks.done');
    Route::resource('tasks', TaskController::class);
});

// Super admin only task routes
Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        if (auth()->user()->role !== 'super-admin') {
            abort(403);
        }
        return $next($request);
    }], function () {
        Route::resource('tasks', TaskController::class)->except(['show']);
    });
});

// Super Admin only: Can assign tasks
Route::middleware(['auth', 'role:super-admin'])->group(function () {
    Route::post('/admins/bulk-assign', [AdminController::class, 'bulkAssign'])->name('admins.bulkAssign');
    Route::resource('admins', AdminController::class);
    Route::resource('tasks', TaskController::class)->except(['show']);
});

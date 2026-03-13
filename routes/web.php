<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;

//WELCOME PAGE//

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

//AUTHENTICATION ROUTES//

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//PROFILE ROUTES//
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

//DASHBOARD ROUTES ALL ROLES//
Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
    ->middleware('auth')->name('admin.dashboard');

Route::get('/teacher/dashboard', [DashboardController::class, 'teacher'])
    ->middleware('auth')->name('teacher.dashboard');

Route::get('/student/dashboard', [DashboardController::class, 'student'])
    ->middleware('auth')->name('student.dashboard');

//DASHBOARD STATS API ENDPOINTS//
Route::get('/api/admin/stats', [DashboardController::class, 'adminStats'])
    ->middleware('auth')->name('api.admin.stats');

Route::get('/api/teacher/stats', [DashboardController::class, 'teacherStats'])
    ->middleware('auth')->name('api.teacher.stats');

Route::get('/api/student/stats', [DashboardController::class, 'studentStats'])
    ->middleware('auth')->name('api.student.stats');

//ADMIN USER MANAGEMENT ROUTES
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/api', [UserController::class, 'storeApi'])->name('users.store.api');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::delete('/users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
});

//ANNOUNCEMENT ROUTES
Route::middleware(['auth'])->prefix('announcements')->name('announcements.')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');
    Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
    Route::post('/', [AnnouncementController::class, 'store'])->name('store');
    Route::get('/{announcement}', [AnnouncementController::class, 'show'])->name('show');
    Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
    Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
    Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
});



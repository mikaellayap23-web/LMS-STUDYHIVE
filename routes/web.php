<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\InformationSheetController;
use App\Http\Controllers\TopicController;

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

//COURSE AND MODULE MANAGEMENT ROUTES
Route::middleware(['auth'])->group(function () {
    // Courses
    Route::resource('courses', CourseController::class);

    // Modules (nested under courses)
    Route::prefix('courses/{course}')->name('courses.')->group(function () {
        Route::get('/modules/create', [ModuleController::class, 'create'])->name('modules.create');
        Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');
        Route::get('/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');
        Route::get('/modules/{module}/edit', [ModuleController::class, 'edit'])->name('modules.edit');
        Route::put('/modules/{module}', [ModuleController::class, 'update'])->name('modules.update');
        Route::delete('/modules/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');

        // Information Sheets (nested under modules)
        Route::prefix('modules/{module}')->name('modules.')->group(function () {
            Route::get('/sheets/create', [InformationSheetController::class, 'create'])->name('sheets.create');
            Route::post('/sheets', [InformationSheetController::class, 'store'])->name('sheets.store');
            Route::get('/sheets/{sheet}/edit', [InformationSheetController::class, 'edit'])->name('sheets.edit');
            Route::put('/sheets/{sheet}', [InformationSheetController::class, 'update'])->name('sheets.update');
            Route::delete('/sheets/{sheet}', [InformationSheetController::class, 'destroy'])->name('sheets.destroy');
            Route::get('/sheets/{sheet}/download', [InformationSheetController::class, 'download'])->name('sheets.download');
        });
    });

    // Topics (under information sheets)
    Route::prefix('sheets/{informationSheet}')->name('sheets.')->group(function () {
        Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
        Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
    });

    // Topic routes
    Route::get('/topics/{topic}', [TopicController::class, 'show'])->name('topics.show');
    Route::get('/topics/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit');
    Route::put('/topics/{topic}', [TopicController::class, 'update'])->name('topics.update');
    Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');
    Route::get('/topics/{topic}/download', [TopicController::class, 'download'])->name('topics.download');
});



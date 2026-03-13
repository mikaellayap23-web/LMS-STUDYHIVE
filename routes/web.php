<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\QuizController;

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

        // Lessons (nested under modules)
        Route::prefix('modules/{module}')->name('modules.')->group(function () {
            Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
            Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store');
            Route::get('/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
            Route::put('/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
            Route::delete('/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
            Route::get('/lessons/{lesson}/download', [LessonController::class, 'download'])->name('lessons.download');
        });
    });

    // Topics (under lessons)
    Route::prefix('lessons/{lesson}')->name('lessons.')->group(function () {
        Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
        Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
    });

    // Topic routes
    Route::get('/topics/{topic}', [TopicController::class, 'show'])->name('topics.show');
    Route::get('/topics/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit');
    Route::put('/topics/{topic}', [TopicController::class, 'update'])->name('topics.update');
    Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');
    Route::get('/topics/{topic}/download', [TopicController::class, 'download'])->name('topics.download');

    // Quizzes (under lessons)
    Route::prefix('lessons/{lesson}')->name('lessons.')->group(function () {
        Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
        Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    });

    // Quiz routes
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');

    // Quiz taking routes
    Route::post('/quizzes/{quiz}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::get('/quizzes/{quiz}/take/{attempt}', [QuizController::class, 'take'])->name('quizzes.take');
    Route::post('/quizzes/{quiz}/submit/{attempt}', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quizzes/{quiz}/result/{attempt}', [QuizController::class, 'result'])->name('quizzes.result');

    // Quiz question management
    Route::post('/quizzes/{quiz}/questions', [QuizController::class, 'addQuestion'])->name('quizzes.questions.store');
    Route::delete('/quizzes/{quiz}/questions/{question}', [QuizController::class, 'removeQuestion'])->name('quizzes.questions.destroy');
});

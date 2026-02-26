<?php

use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterMenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentMenuController;
use App\Http\Controllers\TeacherMenuController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Role switching routes
    Route::post('/role/switch', [RoleController::class, 'switchRole'])->name('role.switch');
    Route::get('/role/active', [RoleController::class, 'getActiveRole'])->name('role.active');

    Route::get('/', DashboardController::class)
        ->name('dashboard')
        ->middleware('can:master.dashboard');

    Route::get('/profile', [MasterMenuController::class, 'profile'])
        ->name('master.profile')
        ->middleware('can:master.information');

    Route::prefix('teacher')->name('teacher.')->middleware(['role_or_permission:teacher|admin', 'active_role:teacher'])->group(function () {
        Route::get('/', [TeacherMenuController::class, 'index'])->name('index');
        Route::get('/my-class', [TeacherMenuController::class, 'show'])->defaults('page', 'my-class')->name('my-class')->middleware('can:teacher.my-class.view');
        Route::get('/classes', [TeacherMenuController::class, 'show'])->defaults('page', 'classes')->name('classes')->middleware('can:teacher.class.view');
        Route::get('/quiz', [TeacherMenuController::class, 'show'])->defaults('page', 'quiz')->name('quiz')->middleware('can:teacher.quiz.view');
        Route::get('/questions', [TeacherMenuController::class, 'show'])->defaults('page', 'questions')->name('questions')->middleware('can:teacher.question.view');
        Route::get('/raports', [TeacherMenuController::class, 'show'])->defaults('page', 'raports')->name('raports')->middleware('can:teacher.report.view');
    });

    Route::prefix('student')->name('student.')->middleware(['role_or_permission:student|admin', 'active_role:student'])->group(function () {
        Route::get('/', [StudentMenuController::class, 'index'])->name('index');
        Route::get('/my-class', [StudentMenuController::class, 'show'])->defaults('page', 'my-class')->name('my-class')->middleware('can:student.my-class.view');
        Route::get('/classes', [StudentMenuController::class, 'show'])->defaults('page', 'classes')->name('classes')->middleware('can:student.class.view');
        Route::get('/certificates', [StudentMenuController::class, 'show'])->defaults('page', 'certificates')->name('certificates')->middleware('can:student.certificate.view');
        Route::get('/raports', [StudentMenuController::class, 'show'])->defaults('page', 'raports')->name('raports')->middleware('can:student.report.view');
    });

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/', [AdminMenuController::class, 'index'])->name('index');
        Route::get('/option/generals', [AdminMenuController::class, 'show'])->defaults('page', 'option/generals')->name('generals')->middleware('can:admin.tool.general');
        Route::get('/log-viewer', [AdminMenuController::class, 'show'])->defaults('page', 'log-viewer')->name('log-viewer')->middleware('can:admin.tool.log');
        Route::get('/email-tester', [AdminMenuController::class, 'show'])->defaults('page', 'email-tester')->name('email-tester')->middleware('can:admin.tool.email-tester');
        Route::get('/queue-cron', [AdminMenuController::class, 'show'])->defaults('page', 'queue-cron')->name('queue-cron')->middleware('can:admin.tool.queue');
        Route::get('/users', [AdminMenuController::class, 'show'])->defaults('page', 'users')->name('users')->middleware('can:admin.user.view');
        Route::get('/roles', [AdminMenuController::class, 'show'])->defaults('page', 'roles')->name('roles')->middleware('can:admin.role.view');
        Route::get('/permissions', [AdminMenuController::class, 'show'])->defaults('page', 'permissions')->name('permissions')->middleware('can:admin.permission.view');
    });
});

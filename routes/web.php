<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');

    Route::middleware('permission:students.manage')->group(function () {
        Route::resource('students', StudentController::class)->names([
            'index' => 'students.index',
            'create' => 'students.create',
            'store' => 'students.store',
            'show' => 'students.show',
            'edit' => 'students.edit',
            'update' => 'students.update',
            'destroy' => 'students.destroy',
        ]);

        Route::post('students/{student}/reset-password', [StudentController::class, 'resetPassword'])
            ->name('students.reset-password');
    });

    Route::middleware('permission:courses.manage')->group(function () {
        Route::resource('semesters', SemesterController::class);
        Route::resource('courses', CourseController::class);
    });

    // Schedule accessible to all authenticated users
    Route::get('schedule', function () {
        return \Inertia\Inertia::render('Schedule', [
            'semesters' => \App\Models\Semester::orderBy('start_date', 'desc')->get(),
        ]);
    })->name('schedule');

    Route::middleware('permission:roles.assign')->group(function () {
        Route::get('users/roles', [RoleController::class, 'index'])->name('users.roles.index');
        Route::post('users/{user}/role', [RoleController::class, 'assign'])->name('users.roles.assign');
    });
});

require __DIR__.'/settings.php';

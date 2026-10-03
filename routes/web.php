<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');

    Route::middleware('permission:roles.assign')->group(function () {
        Route::get('users/roles', [RoleController::class, 'index'])->name('users.roles.index');
        Route::post('users/{user}/role', [RoleController::class, 'assign'])->name('users.roles.assign');
    });
});

require __DIR__.'/settings.php';

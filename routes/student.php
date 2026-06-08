<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Student\StudentDashboardController;

Route::prefix('student')->name('student.')->group(function () {
    Route::middleware('guest:student')->group(function () {
        Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [StudentAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth:student')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('profile');
        Route::post('/courses/{course}/enroll', [StudentDashboardController::class, 'enroll'])->name('courses.enroll');
        Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
    });
});

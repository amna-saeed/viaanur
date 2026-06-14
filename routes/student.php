<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentCourseController;

Route::prefix('student')->name('student.')->group(function () {
    Route::middleware('guest:student')->group(function () {
        Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [StudentAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth:student')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/my-courses', [StudentDashboardController::class, 'myCourses'])->name('my-courses');
        Route::get('/attendance', [StudentDashboardController::class, 'attendance'])->name('attendance');
        Route::post('/leave-requests', [StudentDashboardController::class, 'storeLeaveRequest'])->name('leave-requests.store');
        Route::get('/progress', [StudentDashboardController::class, 'progress'])->name('progress');
        Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('profile');
        Route::post('/courses/{course}/enroll', [StudentDashboardController::class, 'enroll'])->name('courses.enroll');

        Route::get('/courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
        Route::get('/courses/{course}/lessons/{lesson}', [StudentCourseController::class, 'showLesson'])->name('courses.lessons.show');
        Route::get('/courses/{course}/quizzes/{quiz}', [StudentCourseController::class, 'showQuiz'])->name('courses.quizzes.show');
        Route::post('/courses/{course}/quizzes/{quiz}/start', [StudentCourseController::class, 'startQuiz'])->name('courses.quizzes.start');
        Route::get('/courses/{course}/quizzes/{quiz}/attempts/{attempt}', [StudentCourseController::class, 'takeQuiz'])->name('courses.quizzes.take');
        Route::post('/courses/{course}/quizzes/{quiz}/attempts/{attempt}', [StudentCourseController::class, 'submitQuiz'])->name('courses.quizzes.submit');
        Route::get('/courses/{course}/quizzes/{quiz}/attempts/{attempt}/result', [StudentCourseController::class, 'quizResult'])->name('courses.quizzes.result');

        Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
    });
});

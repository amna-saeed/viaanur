<?php

use App\Support\StudentSessionPool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentCourseController;

$legacyStudentRedirect = function (string $routeName) {
    return function (Request $request) use ($routeName) {
        $pool = app(StudentSessionPool::class);
        $token = $request->query('as') ?? $pool->firstToken();

        if ($token === null || $token === '') {
            return redirect()->route('student.login');
        }

        return redirect()->route($routeName, ['studentContext' => $token]);
    };
};

Route::prefix('student')->middleware('default.guard:student')->group(function () use ($legacyStudentRedirect) {
    Route::get('/dashboard', $legacyStudentRedirect('student.dashboard'));
    Route::get('/my-courses', $legacyStudentRedirect('student.my-courses'));
    Route::get('/attendance', $legacyStudentRedirect('student.attendance'));
    Route::get('/progress', $legacyStudentRedirect('student.progress'));
    Route::get('/profile', $legacyStudentRedirect('student.profile'));
});

Route::prefix('student')->name('student.')->middleware('default.guard:student')->group(function () {
    Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [StudentAuthController::class, 'login'])->name('login.submit');

    Route::prefix('s/{studentContext}')
        ->where(['studentContext' => '[A-Za-z0-9]+'])
        ->middleware(['student.session', 'auth:student'])
        ->group(function () {
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

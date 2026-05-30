<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\AdminTeacherController;
use App\Http\Controllers\Admin\AdminEnrollmentController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);
        Route::get('/dashboard/api/stats', [AdminDashboardController::class, 'apiStats'])->name('dashboard.api.stats');

        Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
        Route::get('/students/{student}', [AdminStudentController::class, 'show'])->name('students.show');
        Route::get('/students/{student}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [AdminStudentController::class, 'update'])->name('students.update');

        Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [AdminCourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [AdminCourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [AdminCourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [AdminCourseController::class, 'destroy'])->name('courses.destroy');

        Route::get('courses/{course}/lessons', [LessonController::class, 'index'])->name('lessons.index');
        Route::post('courses/{course}/lessons', [LessonController::class, 'store'])->name('lessons.store');
        Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');

        Route::get('courses/{course}/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
        Route::get('courses/{course}/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
        Route::post('courses/{course}/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
        Route::get('courses/{course}/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
        Route::put('courses/{course}/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
        Route::delete('courses/{course}/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
        Route::get('courses/{course}/quizzes/{quiz}/attempts', [QuizController::class, 'attempts'])->name('quizzes.attempts');

        Route::get('/teachers', [AdminTeacherController::class, 'index'])->name('teachers.index');
        Route::get('/teachers/create', [AdminTeacherController::class, 'create'])->name('teachers.create');
        Route::post('/teachers', [AdminTeacherController::class, 'store'])->name('teachers.store');
        Route::get('/teachers/{teacher}', [AdminTeacherController::class, 'show'])->name('teachers.show');
        Route::get('/teachers/{teacher}/edit', [AdminTeacherController::class, 'edit'])->name('teachers.edit');
        Route::put('/teachers/{teacher}', [AdminTeacherController::class, 'update'])->name('teachers.update');
        Route::delete('/teachers/{teacher}', [AdminTeacherController::class, 'destroy'])->name('teachers.destroy');
        Route::get('/teachers/{teacher}/assign-subject', [AdminTeacherController::class, 'assignSubjectForm'])->name('teachers.assign-subject');
        Route::post('/teachers/{teacher}/assign-subject', [AdminTeacherController::class, 'assignSubject'])->name('teachers.store-subject');
        Route::delete('/teachers/{teacher}/subjects/{subject}', [AdminTeacherController::class, 'removeSubject'])->name('teachers.remove-subject');

        Route::get('/enrollments', [AdminEnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('/enrollments/create', [AdminEnrollmentController::class, 'create'])->name('enrollments.create');
        Route::post('/enrollments', [AdminEnrollmentController::class, 'store'])->name('enrollments.store');
        Route::get('/enrollments/{enrollment}', [AdminEnrollmentController::class, 'show'])->name('enrollments.show');
        Route::delete('/enrollments/{enrollment}', [AdminEnrollmentController::class, 'destroy'])->name('enrollments.destroy');
        Route::post('/enrollments/bulk', [AdminEnrollmentController::class, 'bulkEnroll'])->name('enrollments.bulk');

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

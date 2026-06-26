<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\AdminTeacherController;
use App\Http\Controllers\Admin\AdminApplicationController;
use App\Http\Controllers\Admin\AdminEnrollmentController;
use App\Http\Controllers\Admin\AdminLeaveRequestController;

Route::prefix('admin')->name('admin.')->middleware('default.guard:admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);
        Route::get('/dashboard/api/stats', [AdminDashboardController::class, 'apiStats'])->name('dashboard.api.stats');
        Route::get('/dashboard/api/leave-alerts', [AdminLeaveRequestController::class, 'alerts'])->name('dashboard.api.leave-alerts');

        Route::post('/leave-requests/{leaveRequest}/approve', [AdminLeaveRequestController::class, 'approve'])->name('leave-requests.approve');
        Route::post('/leave-requests/{leaveRequest}/reject', [AdminLeaveRequestController::class, 'reject'])->name('leave-requests.reject');

        Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [AdminStudentController::class, 'create'])->name('students.create');
        Route::post('/students', [AdminStudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}', [AdminStudentController::class, 'show'])->name('students.show');
        Route::get('/students/{student}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [AdminStudentController::class, 'update'])->name('students.update');
        Route::put('/students/{student}/profile-records', [AdminStudentController::class, 'updateProfileRecords'])->name('students.profile-records.update');

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
        Route::post('courses/{course}/quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
        Route::delete('courses/{course}/quizzes/{quiz}/questions/{question}', [QuizController::class, 'destroyQuestion'])->name('quizzes.questions.destroy');

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
        Route::post('/enrollments/{enrollment}/approve', [AdminEnrollmentController::class, 'approve'])->name('enrollments.approve');
        Route::post('/enrollments/{enrollment}/reject', [AdminEnrollmentController::class, 'reject'])->name('enrollments.reject');
        Route::delete('/enrollments/{enrollment}', [AdminEnrollmentController::class, 'destroy'])->name('enrollments.destroy');
        Route::post('/enrollments/bulk', [AdminEnrollmentController::class, 'bulkEnroll'])->name('enrollments.bulk');
        Route::get('/dashboard/api/enrollment-alerts', [AdminEnrollmentController::class, 'alerts'])->name('dashboard.api.enrollment-alerts');

        Route::get('/applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
        Route::post('/applications/{application}/approve', [AdminApplicationController::class, 'approve'])->name('applications.approve');
        Route::post('/applications/{application}/reject', [AdminApplicationController::class, 'reject'])->name('applications.reject');

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

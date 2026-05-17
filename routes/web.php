<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\AdminTeacherController;
use App\Http\Controllers\Admin\AdminEnrollmentController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\SetupAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/application', [ApplicationController::class, 'store'])->name('application.store');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about-us');
Route::get('/teams', [HomeController::class, 'Team'])->name('teams');
Route::get('/courses', [HomeController::class, 'Courses'])->name('courses');
Route::get('/terms-conditions', [HomeController::class, 'termsCondition'])->name('terms-conditions');
Route::get('/privacy-policy', [HomeController::class, 'Privacy'])->name('privacy-policy');  
Route::get('/licensing', [HomeController::class, 'Licensing'])->name('licensing');

Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    // One-time admin creation without /register (enable ALLOW_WEB_ADMIN_SETUP=true in .env)
    Route::get('/setup-admin-account', [SetupAdminController::class, 'show'])->name('setup-admin');
    Route::post('/setup-admin-account', [SetupAdminController::class, 'store'])->name('setup-admin.store');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Claim admin (when no admin exists yet - gets you access to admin/courses)
Route::get('/claim-admin', [AuthController::class, 'claimAdmin'])->name('claim-admin')->middleware('auth');

// Student LMS area — only users with role "student"
Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::post('/courses/{course}/enroll', [StudentDashboardController::class, 'enroll'])->name('courses.enroll');
});

// Admin (auth + admin role only)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    Route::get('/dashboard/api/stats', [AdminDashboardController::class, 'apiStats'])->name('dashboard.api.stats');
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/students/{student}', [AdminStudentController::class, 'show'])->name('students.show');
    Route::get('/students/{student}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [AdminStudentController::class, 'update'])->name('students.update');
    // Courses
    Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [AdminCourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [AdminCourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [AdminCourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [AdminCourseController::class, 'destroy'])->name('courses.destroy');

    Route::get('courses/{course}/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::post('courses/{course}/lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');

    // Quizzes
    Route::get('courses/{course}/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('courses/{course}/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::post('courses/{course}/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('courses/{course}/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('courses/{course}/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('courses/{course}/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::get('courses/{course}/quizzes/{quiz}/attempts', [QuizController::class, 'attempts'])->name('quizzes.attempts');

    // Teachers
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

    // Enrollments
    Route::get('/enrollments', [AdminEnrollmentController::class, 'index'])->name('enrollments.index');
    Route::get('/enrollments/create', [AdminEnrollmentController::class, 'create'])->name('enrollments.create');
    Route::post('/enrollments', [AdminEnrollmentController::class, 'store'])->name('enrollments.store');
    Route::get('/enrollments/{enrollment}', [AdminEnrollmentController::class, 'show'])->name('enrollments.show');
    Route::delete('/enrollments/{enrollment}', [AdminEnrollmentController::class, 'destroy'])->name('enrollments.destroy');
    Route::post('/enrollments/bulk', [AdminEnrollmentController::class, 'bulkEnroll'])->name('enrollments.bulk');
});

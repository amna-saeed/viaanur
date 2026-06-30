<?php

use App\Http\Controllers\Teacher\AuthController as TeacherAuthController;
use App\Http\Controllers\Teacher\TeacherAttendanceController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\TeacherSettingsController;
use App\Http\Controllers\Teacher\TeacherStudentController;
use App\Http\Controllers\Teacher\TeacherSubjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('teacher')->name('teacher.')->middleware('default.guard:teacher')->group(function () {
    Route::middleware('guest:teacher')->group(function () {
        Route::get('/login', [TeacherAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [TeacherAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth:teacher')->group(function () {
        Route::get('/', [TeacherDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [TeacherDashboardController::class, 'index']);

        Route::get('/students', [TeacherStudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [TeacherStudentController::class, 'create'])->name('students.create');
        Route::post('/students', [TeacherStudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}', [TeacherStudentController::class, 'show'])->name('students.show');
        Route::get('/students/{student}/edit', [TeacherStudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [TeacherStudentController::class, 'update'])->name('students.update');
        Route::put('/students/{student}/profile-records', [TeacherStudentController::class, 'updateProfileRecords'])->name('students.profile-records.update');
        Route::get('/students/{student}/assign-subject', [TeacherStudentController::class, 'assignSubjectForm'])->name('students.assign-subject');
        Route::post('/students/{student}/assign-subject', [TeacherStudentController::class, 'assignSubject'])->name('students.store-subject');
        Route::delete('/students/{student}/subjects/{subject}', [TeacherStudentController::class, 'removeSubject'])->name('students.remove-subject');

        Route::get('/subjects', [TeacherSubjectController::class, 'index'])->name('subjects.index');

        Route::get('/attendance', [TeacherAttendanceController::class, 'index'])->name('attendance.index');

        Route::get('/settings', [TeacherSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [TeacherSettingsController::class, 'update'])->name('settings.update');

        Route::post('/logout', [TeacherAuthController::class, 'logout'])->name('logout');
    });
});

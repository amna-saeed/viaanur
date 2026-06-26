<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseDetailController;
use App\Http\Controllers\Auth\AuthController;
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
Route::get('/courses/{slug}', [CourseDetailController::class, 'show'])
    ->name('courses.detail')
    ->where('slug', '[a-z0-9\-]+');
Route::redirect('/courses/primary-ks1-ks2', '/courses/primary-english');
Route::get('/terms-conditions', [HomeController::class, 'termsCondition'])->name('terms-conditions');
Route::get('/privacy-policy', [HomeController::class, 'Privacy'])->name('privacy-policy');  
Route::get('/licensing', [HomeController::class, 'Licensing'])->name('licensing');

Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

// Auth
Route::get('/login', function () {
    return redirect()->route('student.login');
})->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('guest:admin')->group(function () {
    // One-time admin creation without /register (enable ALLOW_WEB_ADMIN_SETUP=true in .env)
    Route::get('/setup-admin-account', [SetupAdminController::class, 'show'])->name('setup-admin');
    Route::post('/setup-admin-account', [SetupAdminController::class, 'store'])->name('setup-admin.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth:web');

// Claim admin (when no admin exists yet - gets you access to admin/courses)
Route::get('/claim-admin', [AuthController::class, 'claimAdmin'])
    ->name('claim-admin')
    ->middleware(['default.guard:student', 'auth:student']);

require __DIR__.'/student.php';
require __DIR__.'/admin.php';

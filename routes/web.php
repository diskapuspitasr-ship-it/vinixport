<?php
use App\Http\Controllers\Guest\GuestAuthController;
use App\Http\Controllers\Guest\GuestHomeController;
use App\Http\Controllers\Guest\GuestPortofolioController;
use App\Http\Controllers\User\UserAnalyticController;
use App\Http\Controllers\User\UserAssessmentController;
use App\Http\Controllers\User\UserCertificateController;
use App\Http\Controllers\User\UserPorofileController;
use App\Http\Controllers\User\UserPortofolioController;
use App\Http\Controllers\User\UserProjectController;
use App\Http\Controllers\User\UserUploadController;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', [GuestHomeController::class, 'index'])->name('guest.dashboard');
Route::get('/portfolio/view/{slug}', [GuestPortofolioController::class, 'index'])->name('guest.portofolio.index');

// Guest Only (Hanya bisa diakses jika belum login)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [GuestAuthController::class, 'login'])->name('guest.login.index');
    Route::post('/login', [GuestAuthController::class, 'authenticate'])->name('guest.login.store');

    // Register
    Route::get('/register', [GuestAuthController::class, 'register'])->name('guest.register.index');
    Route::post('/register', [GuestAuthController::class, 'store'])->name('guest.register.store');
});

// Authenticated Only (Hanya bisa diakses jika sudah login)
Route::middleware(['auth', 'role:user'])->name('user.')->group(function () {
    Route::get('/portfolio', [UserPortofolioController::class, 'index'])->name('portfolio.index');

    Route::get('/upload', [UserUploadController::class, 'index'])->name('upload.index');
    Route::post('/upload', [UserUploadController::class, 'store'])->name('upload.store');

    Route::get('/analytics', [UserAnalyticController::class, 'index'])->name('analytic.index');


    Route::put('/profile', [UserPorofileController::class, 'update'])->name('profile.update');

    Route::get('/assessment', [UserAssessmentController::class, 'index'])->name('assessment.index');
    Route::post('/assessment', [UserAssessmentController::class, 'store'])->name('assessment.store');
    Route::delete('/assessment', [UserAssessmentController::class, 'destroy'])->name('assessment.destroy');

    Route::put('/project/update/{id}', [UserProjectController::class, 'update'])->name('project.update');
    Route::delete('/project/delete/{id}', [UserProjectController::class, 'destroy'])->name('project.delete');

    Route::put('/certificate/update/{id}', [UserCertificateController::class, 'update'])->name('certificate.update');
    Route::delete('/certificate/delete/{id}', [UserCertificateController::class, 'destroy'])->name('certificate.delete');

    Route::post('/logout', [GuestAuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Route::get('/admin/users', [AdminDashboardController::class, 'users'])->name('admin.users');
    // ... route lain khusus admin
});

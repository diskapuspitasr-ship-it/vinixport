<?php
use App\Http\Controllers\Guest\GuestAuthController;
use App\Http\Controllers\Guest\GuestHomeController;
use App\Http\Controllers\User\UserPorofileController;
use App\Http\Controllers\User\UserPortofolioController;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', [GuestHomeController::class, 'index'])->name('guest.dashboard');

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
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/portfolio', [UserPortofolioController::class, 'index'])->name('user.portfolio.index');
    Route::put('/profile', [UserPorofileController::class, 'index'])->name('user.profile.update');
    Route::post('/logout', [GuestAuthController::class, 'logout'])->name('logout');
    // ... route lain khusus user
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Route::get('/admin/users', [AdminDashboardController::class, 'users'])->name('admin.users');
    // ... route lain khusus admin
});

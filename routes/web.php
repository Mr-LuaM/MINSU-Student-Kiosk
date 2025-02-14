<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentKioskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

// === AUTHENTICATED DASHBOARD ===
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// === KIOSK SYSTEM ROUTES (Public Access) ===
Route::get('/', [StudentKioskController::class, 'idle'])->name('kiosk.idle');

Route::prefix('kiosk')->group(function () {
    Route::get('/home', [StudentKioskController::class, 'home'])->name('kiosk.home');
    Route::get('/search', [StudentKioskController::class, 'search'])->name('kiosk.search');
});

// === ADMIN PANEL ROUTES (🔐 Requires Authentication) ===
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // CRUD Routes for Admin Panel (Only Accessible When Logged In)
    Route::resource('students', AdminController::class);
    Route::resource('contacts', AdminController::class);
    Route::resource('academics', AdminController::class);
    Route::resource('skills', AdminController::class);
    Route::resource('achievements', AdminController::class);
});

// === AUTHENTICATION HANDLED BY LARAVEL BREEZE ===
require __DIR__ . '/auth.php';

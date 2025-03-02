<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentKioskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
// use App\Exports\StudentsTemplateExport;
// use App\Exports\StudentsExport;
// use App\Imports\StudentsImport;
// use Illuminate\Http\Request;
// use Maatwebsite\Excel\Facades\Excel;

// === AUTHENTICATED DASHBOARD ===
Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

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

    // Manage Students (Now under AdminController)   // Import/Export Students
    Route::get('/students', [AdminController::class, 'studentsIndex'])->name('admin.students.index');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('admin.students.store');
    Route::get('/students/create', [AdminController::class, 'createStudent'])->name('admin.students.create');
    Route::get('/students/template', [AdminController::class, 'downloadTemplate'])->name('admin.students.template');
    Route::get('/students/export', [AdminController::class, 'exportStudents'])->name('admin.students.export');
    Route::post('/students/import', [AdminController::class, 'importStudents'])->name('admin.students.import');
    Route::get('/students/{id}', [AdminController::class, 'showStudent'])->name('admin.students.show');
    Route::get('/students/{id}/edit', [AdminController::class, 'editStudent'])->name('admin.students.edit');
    Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('admin.students.update');
    Route::delete('/students/{id}', [AdminController::class, 'deleteStudent'])->name('admin.students.destroy');



    // Manage Accounts (Now under AdminController)
    Route::get('/accounts', [AdminController::class, 'accountsIndex'])->name('admin.accounts.index');
    Route::get('/accounts/create', [AdminController::class, 'createAccount'])->name('admin.accounts.create');
    Route::post('/accounts', [AdminController::class, 'storeAccount'])->name('admin.accounts.store');
    // Route::get('/accounts/{id}', [AdminController::class, 'showAccount'])->name('admin.accounts.show'); //remove unneccesary
    // Route::get('/accounts/{id}/edit', [AdminController::class, 'editAccount'])->name('admin.accounts.edit');
    // Route::put('/accounts/{id}', [AdminController::class, 'updateAccount'])->name('admin.accounts.update');
    Route::delete('/accounts/{id}', [AdminController::class, 'deleteAccount'])->name('admin.accounts.destroy');
});



// === AUTHENTICATION HANDLED BY LARAVEL BREEZE ===
require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Halaman utama -> ke login (login akan hantar ke dashboard jika sudah log masuk)
Route::get('/', fn () => redirect()->route('login'));

// ---------- FR1: Log in / Log out ----------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1');   // maksimum 5 cubaan seminit
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ---------- Kawasan Student ----------
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::view('/student/dashboard', 'student.dashboard')->name('student.dashboard');
});

// ---------- Kawasan Admin ----------
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
});
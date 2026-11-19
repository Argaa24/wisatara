<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// Landing Page Publik
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Autentikasi Pengguna (Login, Register, Logout)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dasbor Wisatawan
Route::middleware('auth')->group(function () {
    Route::get('/wisatawan/dashboard', [DashboardController::class, 'wisatawan'])->name('wisatawan.dashboard');
    Route::get('/pemandu/dashboard', [DashboardController::class, 'pemandu'])->name('pemandu.dashboard');
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PemanduController;
use Illuminate\Support\Facades\Route;

// Landing Page Publik
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Inisialisasi Database Cloud (Migrate & Seed Otomatis)
Route::get('/init-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate --force');
        \Illuminate\Support\Facades\Artisan::call('db:seed --force');
        return '<div style="font-family:sans-serif; text-align:center; padding:50px;">
            <h1 style="color:#059669;">✅ Database Berhasil Diisi & Dimigrasikan!</h1>
            <p>Akun admin, pemandu (bagus@wisatara.com), dan wisatawan (michael@gmail.com) sudah siap digunakan.</p>
            <br>
            <a href="/login" style="background:#0f172a; color:#fff; padding:12px 24px; border-radius:10px; text-decoration:none; font-weight:bold;">👉 Pergi ke Halaman Login</a>
        </div>';
    } catch (\Throwable $e) {
        return 'Gagal inisialisasi: ' . $e->getMessage();
    }
});

// Autentikasi Pengguna (Login, Register, Logout)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Fitur Pemesanan Tur (Wisatawan)
Route::get('/paket/{id}/pesan', [BookingController::class, 'showForm'])->name('booking.form');
Route::post('/paket/{id}/pesan', [BookingController::class, 'processBooking'])->name('booking.process')->middleware('auth');

// Dasbor & Fitur Khusus Berdasarkan Role
Route::middleware('auth')->group(function () {
    Route::get('/wisatawan/dashboard', [DashboardController::class, 'wisatawan'])->name('wisatawan.dashboard');
    Route::post('/wisatawan/reservasi/{id}/ulasan', [DashboardController::class, 'kirimUlasan'])->name('wisatawan.reservasi.ulasan');

    Route::get('/pemandu/dashboard', [DashboardController::class, 'pemandu'])->name('pemandu.dashboard');
    Route::post('/pemandu/reservasi/{id}/status', [PemanduController::class, 'updateStatusReservasi'])->name('pemandu.reservasi.status');
    
    // Fitur Pemandu Menambah Paket Tur Mandiri
    Route::get('/pemandu/paket/create', [PemanduController::class, 'createPaket'])->name('pemandu.paket.create');
    Route::post('/pemandu/paket', [PemanduController::class, 'storePaket'])->name('pemandu.paket.store');
});

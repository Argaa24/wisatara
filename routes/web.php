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

        // Reset password admin dan demo user dengan hash tunggal
        $admin = \App\Models\User::where('email', 'admin@wisatara.com')->first();
        if ($admin) {
            $admin->password = \Illuminate\Support\Facades\Hash::make('admin123');
            $admin->role = 'admin';
            $admin->save();
        }

        $bagus = \App\Models\User::where('email', 'bagus@wisatara.com')->first();
        if ($bagus) {
            $bagus->password = \Illuminate\Support\Facades\Hash::make('password123');
            $bagus->save();
        }

        $michael = \App\Models\User::where('email', 'michael@gmail.com')->first();
        if ($michael) {
            $michael->password = \Illuminate\Support\Facades\Hash::make('password123');
            $michael->save();
        }

        return '<div style="font-family:sans-serif; text-align:center; padding:50px;">
            <h1 style="color:#059669;">✅ Password Berhasil Direset & Database Siap!</h1>
            <p>Admin: admin@wisatara.com (pw: admin123)<br>Pemandu: bagus@wisatara.com (pw: password123)<br>Wisatawan: michael@gmail.com (pw: password123)</p>
            <br>
            <a href="/admin/login" style="background:#0f172a; color:#fff; padding:12px 24px; border-radius:10px; text-decoration:none; font-weight:bold;">👉 Masuk ke Dasbor Admin</a>
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

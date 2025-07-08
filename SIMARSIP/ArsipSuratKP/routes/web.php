<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Middleware\RedirectIfAuthenticatedManual;
use Illuminate\Support\Facades\Route;

// Login routes, dilindungi middleware agar user login tidak bisa buka login lagi
Route::middleware(RedirectIfAuthenticatedManual::class)->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout (tidak perlu middleware, bebas diakses kapan saja)
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Semua halaman utama pakai middleware auth
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Surat Masuk
    Route::get('/suratMasuk', [SuratMasukController::class, 'get'])->name('suratMasuk'); // Ke halaman surat masuk
    Route::get('/suratMasuk/create', [SuratMasukController::class, 'create'])->name('suratMasuk.create'); // Ke halaman tambah surat masuk
    Route::post('/suratMasuk', [SuratMasukController::class, 'store'])->name('suratMasuk.store'); // Menyimpan ke database
    Route::get('/suratMasuk/{id}/edit', [SuratMasukController::class, 'edit'])->name('suratMasuk.edit'); // Ke halaman edit surat masuk
    Route::put('/suratMasuk/update/{id}', [SuratMasukController::class, 'update'])->name('suratMasuk.update'); // Menyimpan perubahan ke database


    // Surat Keluar
    Route::get('/suratKeluar', [SuratKeluarController::class, 'get'])->name('suratKeluar'); // Ke halaman surat keluar
    Route::get('/suratKeluar/create', [SuratKeluarController::class, 'create'])->name('suratKeluar.create'); // Ke halaman tambah surat keluar
    Route::post('/suratKeluar', [SuratKeluarController::class, 'store'])->name('suratKeluar.store'); // Menyimpan ke database
    Route::get('/suratKeluar/{id}/edit', [SuratKeluarController::class, 'edit'])->name('suratKeluar.edit'); // Le halaman edit surat keluar
    Route::put('/suratKeluar/update/{id}', [SuratKeluarController::class, 'update'])->name('suratKeluar.update'); // Menyimpan perubahan ke database
});

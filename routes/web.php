<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', fn () => redirect('/'))->name('login'); // Login via modal di home
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
});

// Login admin
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Login petugas
Route::get('/petugas/login', [PetugasAuthController::class, 'showLoginForm'])->name('petugas.login');
Route::post('/petugas/login', [PetugasAuthController::class, 'login']);
Route::post('/petugas/logout', [PetugasAuthController::class, 'logout'])->name('petugas.logout');

// Dashboard Admin
Route::middleware(['auth:admin', 'admin.auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/tanggapan', [TanggapanController::class, 'store'])->name('admin.tanggapan.store');
    Route::delete('/admin/tanggapan/{id}', [TanggapanController::class, 'destroy'])->name('admin.tanggapan.destroy');
    Route::get('/admin/laporan', [AdminController::class, 'generateReport'])->name('admin.laporan');
});

// Dashboard Petugas
Route::middleware(['auth:petugas', 'petugas.auth'])->group(function () {
    Route::get('/petugas/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
    Route::post('/petugas/tanggapan', [TanggapanController::class, 'store'])->name('petugas.tanggapan.store');
    Route::delete('/petugas/tanggapan/{id}', [TanggapanController::class, 'destroy'])->name('petugas.tanggapan.destroy');
});
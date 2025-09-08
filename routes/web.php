<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/login', fn () => redirect()->route('landing'))->name('login');

/*
|--------------------------------------------------------------------------
| Auth Masyarakat
|--------------------------------------------------------------------------
*/
Route::middleware('guest:masyarakat')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth:masyarakat')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('pengaduan', PengaduanController::class)->except(['show']);
    Route::get('/log-pengaduan', [PengaduanController::class, 'index'])->name('log.pengaduan');
});

/*
|--------------------------------------------------------------------------
| Auth Admin & Petugas
|--------------------------------------------------------------------------
*/
Route::middleware('guest:admin,petugas')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    // Dashboard & Logout
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');

    // Pengaduan CRUD & Actions
    Route::get('/pengaduan', [PengaduanController::class, 'indexAdmin'])->name('pengaduan.index');
    Route::get('/pengaduan/{id}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
    Route::put('/pengaduan/{id}', [PengaduanController::class, 'update'])->name('pengaduan.update');
    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
    Route::post('/pengaduan/{id}/verifikasi', [PengaduanController::class, 'verifikasi'])->name('pengaduan.verifikasi');
    Route::post('/pengaduan/{id}/selesai', [PengaduanController::class, 'selesai'])->name('pengaduan.selesai');

    // Tanggapan CRUD
    Route::get('/tanggapan', [TanggapanController::class, 'index'])->name('tanggapan.index');
    Route::put('/tanggapan/{id_pengaduan}', [TanggapanController::class, 'storeOrUpdate'])->name('tanggapan.update');
    Route::delete('/tanggapan/{id}', [TanggapanController::class, 'destroy'])->name('tanggapan.destroy');
    Route::patch('/tanggapan/{id_pengaduan}/status', [TanggapanController::class, 'updateStatus'])->name('tanggapan.status');

    // Petugas CRUD
    Route::get('/register', [StaffController::class, 'indexPetugas'])->name('register'); 
    Route::post('/register', [StaffController::class, 'storePetugas'])->name('register.post'); 
    Route::get('/register/{id}/edit', [StaffController::class, 'editPetugas'])->name('register.edit'); 
    Route::put('/register/{id}', [StaffController::class, 'updatePetugas'])->name('register.update'); 
    Route::delete('/register/{id}', [StaffController::class, 'destroyPetugas'])->name('register.destroy'); 
});

/*
|--------------------------------------------------------------------------
| Petugas Routes
|--------------------------------------------------------------------------
*/
Route::prefix('petugas')->name('petugas.')->middleware('auth:petugas')->group(function () {
    // Dashboard & Logout
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');

    // Pengaduan CRUD & Actions
    Route::get('/pengaduan', [PengaduanController::class, 'indexPetugas'])->name('pengaduan.index');
    Route::get('/pengaduan/{id}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
    Route::put('/pengaduan/{id}', [PengaduanController::class, 'update'])->name('pengaduan.update');
    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
    Route::post('/pengaduan/{id}/verifikasi', [PengaduanController::class, 'verifikasi'])->name('pengaduan.verifikasi');
    Route::post('/pengaduan/{id}/selesai', [PengaduanController::class, 'selesai'])->name('pengaduan.selesai');

    // Tanggapan CRUD
    Route::get('/tanggapan', [TanggapanController::class, 'index'])->name('tanggapan.index');
    Route::put('/tanggapan/{id_pengaduan}', [TanggapanController::class, 'storeOrUpdate'])->name('tanggapan.update');
    Route::delete('/tanggapan/{id}', [TanggapanController::class, 'destroy'])->name('tanggapan.destroy');
    Route::patch('/tanggapan/{id_pengaduan}/status', [TanggapanController::class, 'updateStatus'])->name('tanggapan.status');
});

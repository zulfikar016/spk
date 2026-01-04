<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PerhitunganController;

// Authentication Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Data Kurir
    Route::resource('kurir', KurirController::class)->except(['show']);
    Route::get('/kurir/{kurir}/detail', [KurirController::class, 'show'])->name('kurir.show');
    
    // Kriteria & Bobot
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/kriteria/{kriteria}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
    Route::put('/kriteria/{kriteria}', [KriteriaController::class, 'update'])->name('kriteria.update');
    
    // Perhitungan SMART
    Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');
    Route::post('/perhitungan/hitung', [PerhitunganController::class, 'hitungSmart'])->name('perhitungan.hitung');
    
    // Ranking Kurir
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/generate-pdf', [LaporanController::class, 'generatePDF'])->name('laporan.generate.pdf');

    Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');
    Route::get('/periode/create', [PeriodeController::class, 'create'])->name('periode.create');
    Route::post('/periode/store', [PeriodeController::class, 'store'])->name('periode.store');
    Route::get('/periode/edit/{id}', [PeriodeController::class, 'edit'])->name('periode.edit');
    Route::put('/periode/update/{id}', [PeriodeController::class, 'update'])->name('periode.update');
    Route::delete('/periode/delete/{id}', [PeriodeController::class, 'destroy'])->name('periode.destroy');

    // Route khusus untuk periode
    Route::post('/periode/activate/{id}', [PeriodeController::class, 'activate'])->name('periode.activate');
    Route::post('/periode/copy/{id}', [PeriodeController::class, 'copy'])->name('periode.copy');
    Route::post('/periode/update-status', [PeriodeController::class, 'updateStatus'])->name('periode.update-status');
    
    // Role-based routes
    Route::middleware(['role:admin,manager'])->group(function () {
        Route::get('/users', function () {
            return view('users.index');
        })->name('users.index');
    });
});
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\Pengaduan;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MasyarakatDashboardController;
use App\Http\Controllers\PengaduanExportController;
use App\Http\Controllers\UserExportController;



// Route awal (halaman landing)
Route::get('/', function () {
    return view('welcome');
});

// Route dashboard umum, redirect berdasarkan role
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'masyarakat') {
        return redirect()->route('masyarakat.dashboard');
    }

    abort(403);
})->name('dashboard');

// Route untuk admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    //dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin lihat semua pengaduan
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
    Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');
    Route::delete('/pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');

    // Tanggapan
    Route::get('/pengaduan/{id}/tanggapan', [PengaduanController::class, 'createTanggapan'])->name('pengaduan.tanggapan.create');
    Route::post('/pengaduan/{id}/tanggapan', [PengaduanController::class, 'storeTanggapan'])->name('pengaduan.tanggapan.store');

    // Manajemen user
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::resource('user', UserController::class)->only(['index', 'show', 'destroy']);

    // Export data
    // Route export PDF dan excel pengaduan
    Route::get('/pengaduan/export/pdf', [PengaduanExportController::class, 'exportPdf'])->name('pengaduan.export.pdf');
    Route::get('/pengaduan/export/excel', [PengaduanExportController::class, 'exportExcel'])->name('pengaduan.export.excel');

    // Route export PDF dan excel users
    Route::get('/users/export/pdf', [UserExportController::class, 'exportPdf'])->name('users.export.pdf');
    Route::get('/users/export/excel', [UserExportController::class, 'exportExcel'])->name('users.export.excel');

});

// Route untuk masyarakat
Route::middleware(['auth', 'role:masyarakat'])->prefix('masyarakat')->name('masyarakat.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [MasyarakatDashboardController::class, 'index'])->name('dashboard');

    // Masyarakat lihat pengaduannya sendiri
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
    Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');
    Route::delete('/pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
});

// Route profile (bisa diakses semua yang login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route auth bawaan
require __DIR__.'/auth.php';

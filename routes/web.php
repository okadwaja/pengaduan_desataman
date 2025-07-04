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
use App\Http\Controllers\KepalaDesaDashboardController;
use App\Http\Controllers\AdminPetugasController;



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
    }elseif ($role === 'kepala_desa') {
        return redirect()->route('kepala_desa.dashboard');
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

    //Route export PDF detail pengaduan
    Route::get('/pengaduan/{id}/export/pdf', [PengaduanController::class, 'exportDetailPdf'])
        ->name('pengaduan.export.detail.pdf');

    // Route export PDF detail users
    Route::get('/user/{id}/export/pdf', [UserController::class, 'exportDetailPdf'])
        ->name('users.export.detail.pdf');
    
    // Manajemen Petugas (admin & kepala desa)
    Route::prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/', [AdminPetugasController::class, 'index'])->name('index');
        Route::get('/create', [AdminPetugasController::class, 'create'])->name('create');
        Route::post('/', [AdminPetugasController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminPetugasController::class, 'show'])->name('show');
        Route::delete('/{id}', [AdminPetugasController::class, 'destroy'])->name('destroy');
    });

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

    // Fitur Export
    Route::get('/pengaduan/{id}/export/pdf', [PengaduanController::class, 'exportDetailPdfMasyarakat'])
    ->name('pengaduan.export.detail.pdf');

});

// Route untuk Kepala Desa
Route::middleware(['auth', 'role:kepala_desa'])->prefix('kepala-desa')->name('kepala_desa.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [KepalaDesaDashboardController::class, 'index'])->name('dashboard');
    //Pengaduan
    Route::get('/pengaduan', [PengaduanController::class, 'indexKepalaDesa'])->name('pengaduan.index');
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    // Tanggapan
    Route::get('/pengaduan/{id}/tanggapan', [PengaduanController::class, 'createTanggapan'])->name('pengaduan.tanggapan.create');
    Route::post('/pengaduan/{id}/tanggapan', [PengaduanController::class, 'storeTanggapan'])->name('pengaduan.tanggapan.store');
    // Route export PDF dan excel pengaduan
    Route::get('/pengaduan/export/pdf', [PengaduanExportController::class, 'exportPdf'])->name('pengaduan.export.pdf');
    Route::get('/pengaduan/export/excel', [PengaduanExportController::class, 'exportExcel'])->name('pengaduan.export.excel');
    // Route export PDF detail pengaduan
    Route::get('/pengaduan/{id}/export/pdf', [PengaduanController::class, 'exportDetailPdf'])
        ->name('pengaduan.export.detail.pdf');


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

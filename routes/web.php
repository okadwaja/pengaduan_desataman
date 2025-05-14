<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route awal (halaman landing)
Route::get('/', function () {
    return view('welcome');
});

// Route dashboard umum, redirect berdasarkan role
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'masyarakat') {
        return redirect()->route('masyarakat.dashboard');
    }

    abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Admin bisa lihat semua pengaduan
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');

    // Resource route lainnya (create, store, show, edit, update, destroy)
    Route::resource('pengaduan', PengaduanController::class)->except(['index']);

    //tanggapan
    Route::get('/pengaduan/{id}/tanggapan', [PengaduanController::class, 'createTanggapan'])->name('pengaduan.tanggapan.create');
    Route::post('/pengaduan/{id}/tanggapan', [PengaduanController::class, 'storeTanggapan'])->name('pengaduan.tanggapan.store');

    // Manajemen user (read dan delete saja)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::resource('user', UserController::class)->only(['index', 'show', 'destroy']);
});


// Route untuk masyarakat
Route::middleware(['auth', 'role:masyarakat'])->prefix('masyarakat')->name('masyarakat.')->group(function () {
    Route::get('/dashboard', function () {
        return view('masyarakat.dashboard');
    })->name('dashboard');

    // Route index untuk masyarakat melihat daftar pengaduan miliknya
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');

    // Resource route lainnya (create, store, show, edit, update, destroy)
    Route::resource('pengaduan', PengaduanController::class)->except(['index']);
});


// Route profile (bisa diakses semua yang login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

});

// Route auth bawaan
require __DIR__.'/auth.php';

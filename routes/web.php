<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AuthController;


// Rute untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    // Batasi 5 percobaan login per menit untuk mencegah brute force
    Route::post('/login', [AuthController::class, 'loginProcess'])->middleware('throttle:5,1');
});


// Rute terproteksi (harus login)
Route::middleware('auth')->group(function () {
    // Routes untuk Dashboard
    Route::get('/dashboard', [BukuController::class, 'dashboard'])->name('dashboard');

    // Routes untuk Data buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/destroy/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



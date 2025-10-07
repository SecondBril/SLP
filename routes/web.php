<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamController;

// Redirect root URL ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Routes untuk Dashboard
Route::get('/dashboard', [PeminjamController::class, 'dashboard'])->name('dashboard');

// Routes untuk Data Peminjam
Route::get('/peminjam', [PeminjamController::class, 'index'])->name('peminjam.index');
Route::get('/peminjam/create', [PeminjamController::class, 'create'])->name('peminjam.create');
Route::post('/peminjam', [PeminjamController::class, 'store'])->name('peminjam.store');

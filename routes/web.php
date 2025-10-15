<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

// Redirect root URL ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Routes untuk Dashboard
Route::get('/dashboard', [BukuController::class, 'dashboard'])->name('dashboard');

// Routes untuk Data buku
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/destroy/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');

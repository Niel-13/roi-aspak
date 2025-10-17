<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('roi');
// Route::get('/provinsi/{namaProvinsi}', [DashboardController::class, 'show'])->name('provinsi.show');
Route::get('/provinsi/{nama}', [DashboardController::class, 'showProvinsiDetail'])->name('provinsi.detail');
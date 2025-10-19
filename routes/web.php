<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('roi');
Route::get('/provinsi/{nama}', [DashboardController::class, 'showProvinsiDetail'])->name('provinsi.detail');
Route::get('/kabupaten/{kabupaten}', [DashboardController::class, 'showKabupatenDetail'])->name('kabupaten.detail');
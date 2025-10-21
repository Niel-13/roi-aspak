<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DashboardController;



Route::get('/', [DashboardController::class, 'index'])->name('roi');
Route::get('/provinsi/{nama}', [DashboardController::class, 'showProvinsiDetail'])->name('provinsi.detail');
Route::get('/kabupaten/{kabupaten}', [DashboardController::class, 'showKabupatenDetail'])->name('kabupaten.detail');
Route::get('/hospital/{hospital}', [HospitalController::class, 'show'])->name('hospital.detail');
Route::prefix('api')->group(function () {
    Route::get('/rooms/{room}/products', [HospitalController::class, 'getProducts']);
});
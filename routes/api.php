<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HospitalController;

Route::get('/rooms/{room}/products', [HospitalController::class, 'getProducts']);
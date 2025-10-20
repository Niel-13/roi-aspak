<?php
use App\Http\Controllers\HospitalController;

Route::get('/rooms/{room}/products', [HospitalController::class, 'getProducts']);
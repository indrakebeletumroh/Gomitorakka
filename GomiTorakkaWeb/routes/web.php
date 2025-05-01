<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarkerController;

Route::get('/', function () {
    return view('Home');
});

Route::get('/maps', function () {
    return view('maps');
});

Route::get('/register', [AuthController::class, 'form_register'])->name('form_register.tampil');
Route::post('/register/submit', [AuthController::class, 'submit'])->name('form_register.submit');
Route::get('/login',[AuthController::class, 'form_login'])->name('form_login.tampil');
Route::post('/login/submit', [AuthController::class, 'login'])->name('form_login.submit');

Route::get('/markers', [MarkerController::class, 'index']);
Route::post('/markers', [MarkerController::class, 'store']);


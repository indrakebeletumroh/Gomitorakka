<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Home');
});

Route::get('/maps', function (){
    return view('Maps');
});

Route::get('/register', [AuthController::class, 'form_register'])->name('form_register.tampil');
Route::post('/register/submit', [AuthController::class, 'submit'])->name('form_register.submit');
Route::get('/login',[AuthController::class, 'form_login'])->name('form_login.tampil');

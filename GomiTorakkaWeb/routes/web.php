<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Home');
});

Route::get('/maps', function (){
    return view('Maps');
});

Route::get('/login', function (){
    return view('Login');
});

Route::get('/register', function (){
    return view('Register');
});
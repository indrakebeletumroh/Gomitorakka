<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('Home');
});

Route::get('/maps', function () {
    return view('maps');
});

Route::get('/feed', [PostController::class, 'index'])->name('posts.index');

Route::get('/about', function () {
    return view('aboutus');
});

Route::get('/contact', function () {
    return view('contactus');
});

Route::get('/edit-profile', function () {
    return view('edit_profile');
})->name('edit_profile');

Route::post('/edit-profile', [AuthController::class, 'update'])->name('profile.update');

Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'form_register'])->name('form_register.tampil');
Route::post('/register/submit', [AuthController::class, 'submit'])->name('form_register.submit');

Route::get('/login', [AuthController::class, 'form_login'])->name('login');
Route::post('/login/submit', [AuthController::class, 'login'])->name('form_login.submit');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

Route::get('/markers', [MarkerController::class, 'index']);
Route::post('/markers', [MarkerController::class, 'store']);
Route::post('/markers/{id}/status', [MarkerController::class, 'updateStatus']);

// Post & Like
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
Route::get('/request', [MarkerController::class, 'requestPanel']);

Route::post('/posts/{post}/comments', [PostCommentController::class, 'store'])->name('posts.comments.store');
Route::get('/posts/{post}/comments', [PostController::class, 'fetchComments']);

Route::get('/adminpanel', [UserController::class, 'UserPanel'])->name('user.panel');

// Hapus user berdasarkan uid dengan method DELETE
Route::delete('/adminpanel/user/{uid}', [UserController::class, 'destroy'])->name('user.destroy');

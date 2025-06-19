<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InboxController;
use App\Http\Middleware\CheckLogin;

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

Route::get('/register', [AuthController::class, 'form_register'])->name('form_register.tampil');
Route::post('/register/submit', [AuthController::class, 'submit'])->name('form_register.submit');

Route::get('/login', [AuthController::class, 'form_login'])->name('login');
Route::post('/login/submit', [AuthController::class, 'login'])->name('form_login.submit');

Route::get('/markers', [MarkerController::class, 'index']);

Route::middleware([CheckLogin::class])->group(function () {
    Route::get('/edit-profile', function () {
        return view('edit_profile');
    })->name('edit_profile');

    Route::post('/edit-profile', [AuthController::class, 'update'])->name('profile.update');

    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

    Route::post('/markers', [MarkerController::class, 'store']);
    Route::post('/markers/{id}/status', [MarkerController::class, 'updateStatus']);
    Route::post('/upload-marker-image', [MarkerController::class, 'uploadImage']);
    // Post & Like
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
    Route::get('/request', [MarkerController::class, 'requestPanel']);

    Route::post('/posts/{post}/comments', [PostCommentController::class, 'store'])->name('posts.comments.store');
    Route::get('/posts/{post}/comments', [PostController::class, 'fetchComments']);

    Route::get('/adminpanel', [UserController::class, 'UserPanel'])->name('user.panel');
    Route::put('/users/{uid}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{uid}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{uid}/promote', [UserController::class, 'promoteToAdmin'])->name('users.promote');
    Route::post('/users/{uid}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::post('/users/{uid}/activate', [UserController::class, 'activate'])->name('users.activate');

    Route::get('/inbox/{uid}', [InboxController::class, 'index'])->name('inbox.index');
    // Tandai pesan sebagai sudah dibaca
    Route::post('/inbox/{id}/read', [\App\Http\Controllers\InboxController::class, 'markAsRead'])->name('inbox.read');
    // Hapus pesan inbox
    Route::delete('/inbox/{id}', [InboxController::class, 'destroy'])->name('inbox.delete');

    Route::get('/api/inbox', function () {
        $uid = session('uid');
        if (!$uid) return response()->json([], 401);

        $inbox = \App\Models\Inbox::where('user_id', $uid)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($inbox);
    });

    Route::get('/inbox', [InboxController::class, 'getInbox']);
    Route::post('/inbox/mark-as-read', [InboxController::class, 'markAsRead']);
});

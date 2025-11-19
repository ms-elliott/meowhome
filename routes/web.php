<?php

use App\Http\Controllers\ApplyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ユーザー管理
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show')->middleware('auth');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/{id}/edit', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.delete')->middleware('auth');

// 認証
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// マイページ
Route::get('/mypage/{id}', [MyPageController::class, 'show'])->name('mypage.show');

// 募集
Route::get('/posts/index/{id}', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::post('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{id}', [PostController::class, 'delete'])->name('posts.delete');

// マッチした募集
Route::get('/posts/matchings/{user}', [PostController::class, 'matchingsIndex'])->name('matchings.index');

// お気に入り
Route::post('/posts/{post}/like/', [LikeController::class, 'toggleLike'])->name('posts.like');
Route::get('/likes/{user}', [LikeController::class, 'index'])->name('likes.index');

// 応募
Route::get('/applies/create/{id}', [ApplyController::class, 'create'])->name('applies.create');
Route::post('/applies/create/{id}', [ApplyController::class, 'store'])->name('applies.store');
Route::get('/applies/index/applicant/{user_id}', [ApplyController::class, 'indexForApplicant'])->name('applies.indexApplicant');
Route::get('/applies/index/post/{post_id}', [ApplyController::class, 'indexForPost'])->name('applies.indexPost');

// メッセージ
Route::get('/messages/index/{user_id}', [MessageController::class, 'index'])->name('messages.index');
Route::get('/messages/{post_id}/{applied_id}', [MessageController::class, 'show'])->name('messages.show');
Route::post('/messages/{post_id}/{user_id}', [MessageController::class, 'store'])->name('messages.store');

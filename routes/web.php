<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::view('profile','profile')->name('profile');//Modification needed
});

Route::get('/users/{user:username}/posts', [UserPostController::class,'index'])->name('users.posts');

Route::get('/posts',[PostController::class,'index'])->name('posts');
Route::get('/posts/{post}',[PostController::class,'show'])->name('posts.show');
Route::post('/posts',[PostController::class,'store']);
Route::delete('/posts/{post}',[PostController::class,'destroy'])->name('posts.destroy');

Route::post('/posts/{post}/likes',[PostLikeController::class,'store'])->name('posts.likes');
Route::delete('/posts/{post}/likes',[PostLikeController::class,'destroy'])->name('posts.likes');

Route::post('/posts/{post}/comment',[CommentController::class,'store'])->name('comments');
Route::delete('/comment/{comment}',[CommentController::class,'destroy'])->name('comments.destroy');

Route::get('/bookmarks',[BookmarkController::class,'index'])->name('bookmarks');//Undone view
Route::post('/posts/{post}/bookmark',[BookmarkController::class,'store'])->name('posts.bookmark');//Done
Route::delete('/posts/{post}/bookmark',[BookmarkController::class,'destroy'])->name('posts.bookmark');//Done
require __DIR__.'/auth.php';

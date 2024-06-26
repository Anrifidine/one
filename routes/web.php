<?php

use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('auth/home', [App\Http\Controllers\Auth\HomeController::class, 'index'])->name('auth.home')->middleware('isAdmin');

Route::get('user/home', [App\Http\Controllers\User\HomeController::class, 'index'])->name('user.home');
// Route::get('/', [App\Http\Controllers\User\HomeController::class, 'index'])->name('user.home');





Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/home', [App\Http\Controllers\Auth\HomeController::class, 'index'])->name('auth.home');
    Route::get('/users', [UserController::class, 'index'])->name('auth.users');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');
    Route::get('/commentaires/{postId}', [CommentaireController::class, 'index'])->name('commentaires.index');
    Route::post('/commentaires/{commentaire}', 'CommentaireController@update')->name('commentaires.update');
    Route::delete('/commentaires/{commentaire}', 'CommentaireController@destroy')->name('commentaires.destroy');
});

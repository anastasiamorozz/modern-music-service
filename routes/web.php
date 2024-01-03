<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

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

//Route::get('/', [TrackController::class, 'index'])->name('home');

// function () {
//     return view('home');

Route::get('/dashboard', [TrackController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/search', [TrackController::class, 'search'])->name('search');
Route::get('/home', [TrackController::class, 'index'])->name('home');
Route::get('/track/{id}', [TrackController::class, 'showTrack'])->name('track.detail');
Route::get('/rank', [TrackController::class, 'mostLikedTracks'])->name('track.rank');

Route::resource('comments', CommentController::class)->middleware('auth');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');

// Route::get('/user-commented-tracks', [CommentController::class, 'userCommentedTracks'])->name('user_commented_tracks');
Route::post('/track/{id}/like', [TrackController::class, 'likeTrack'])->name('track.like');

Route::post('/like/add/{trackId}', [LikeController::class, 'addLike'])->name('like.add');
Route::post('/like/remove/{trackId}', [LikeController::class, 'removeLike'])->name('like.remove');

require __DIR__ . '/auth.php';

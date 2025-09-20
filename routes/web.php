<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\SeriesController;
use App\Http\Controllers\User\EpisodeController;
use App\Http\Controllers\User\Auth\AuthController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\RandomShowController;
use App\Http\Controllers\User\Auth\RegisterController;

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/search', [HomeController::class, 'search'])->name('search');

    Route::get('/series/{series}', [SeriesController::class, 'show'])->name('series.show');
    Route::post('/series/{series}/toggle-follow', [SeriesController::class, 'toggleFollow'])->name('series.toggle-follow');

    Route::get('/episodes/{episode}', [EpisodeController::class, 'show'])->name('episodes.show');
    Route::post('/episodes/{episode}/toggle-like', [EpisodeController::class, 'toggleLike'])->name('episodes.toggle-like');

    Route::get('/random-shows', [RandomShowController::class, 'randomShows']);


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/{any}', function () {
    return redirect('/login');
})->where('any', '.*')->middleware('guest');

<?php

use App\Http\Controllers\Api\MusicController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('/login', [UserController::class, 'login'])->name('user.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', fn(Request $request) => $request->user());
        Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
    });
});

Route::prefix('/musics')->group(function () {
    Route::get('/', [MusicController::class, 'index'])->name('musics.index');
    Route::get('/{id}', [MusicController::class, 'show'])->name('musics.show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [MusicController::class, 'store'])->name('musics.store');
        Route::match(['put', 'patch'], '/{id}', [MusicController::class, 'update'])->name('musics.update');
        Route::delete('/{id}', [MusicController::class, 'destroy'])->name('musics.destroy');
    });
});

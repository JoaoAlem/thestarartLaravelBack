<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MusicController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/musics')->group(function () {
    Route::get('/', [MusicController::class, 'index'])->name('musics.index');
    Route::get('/{id}', [MusicController::class, 'show'])->name('musics.show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [MusicController::class, 'store'])->name('musics.store');
        Route::match(['put', 'patch'], '/{id}', [MusicController::class, 'update'])->name('musics.update');
        Route::delete('/{id}', [MusicController::class, 'destroy'])->name('musics.destroy');
    });
});

<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\JobListingController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware(['auth:sanctum']);
        Route::get('user', [AuthController::class, 'user'])->name('user')->middleware(['auth:sanctum']);
    });

    Route::apiResource('listings',JobListingController::class)->middleware(['auth:sanctum']);
});

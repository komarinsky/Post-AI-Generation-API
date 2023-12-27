<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['api'])->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('resend', 'resend');
        Route::get('email/verify/{id}', 'verify')->name('verification.verify');
    });
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('me', [UserController::class, 'getMe']);

        Route::prefix('users')->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('/', 'index');
                Route::get('{user}', 'show');
                Route::post('media', 'storeMedia');
            });
        });

        Route::prefix('posts')->group(function () {
            Route::controller(PostController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/', 'store');
                Route::get('{post}', 'show');
                Route::put('{post}', 'update');
                Route::delete('{post}', 'destroy');
                Route::put('{post}/like', 'updateLike');
                Route::post('{post}/media', 'storeMedia');
            });
        });

        Route::prefix('media')->group(function () {
            Route::controller(MediaController::class)->group(function () {
                Route::get('/', [MediaController::class, 'index']);
                Route::get('{media}', [MediaController::class, 'show']);
                Route::put('{media}', [MediaController::class, 'update']);
                Route::delete('{media}', [MediaController::class, 'destroy']);
            });
        });
    });
});

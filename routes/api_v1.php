<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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
    Route::post('register', [AuthController::class, 'register']);
    Route::get('email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify');
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('me', [UserController::class, 'getMe']);
        Route::get('users', [UserController::class, 'index']);

        Route::prefix('post')->group(function () {
            Route::controller(PostController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/', 'store');
                Route::post('{Post}', 'show');
                Route::post('{Post}', 'update');
                Route::post('{Post}', 'destroy');
            });
        });
    });
});

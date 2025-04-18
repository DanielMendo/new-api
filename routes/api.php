<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\PasswordResetController;

Route::apiResource('users', UserController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])
    ->name('password.email');


Route::post('/google/callback', [SocialAuthController::class, 'loginWithGoogle']);
Route::post('/facebook/callback', [SocialAuthController::class, 'loginWithFacebook']);

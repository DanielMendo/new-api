<?php

use App\Http\Controllers\Api\LoginController;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LogoutController;


Route::apiResource('users', UserController::class);
Route::middleware('auth:sanctum')->group(function () { 
    Route::post('/logout', [LogoutController::class, 'logout']);
    
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);








//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
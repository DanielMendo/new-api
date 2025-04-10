<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

Route::apiResource('users', UserController::class);
Route::middleware('auth:sanctum')->group(function () {

});
Route::post('/register', [AuthController::class, 'register']);


//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
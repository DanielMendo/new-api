<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\EditorImageController;
use App\Http\Controllers\Api\PasswordResetController;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']);

    Route::post('/editor/image/upload', [EditorImageController::class, 'upload']);

    Route::post('/posts/create', [PostController::class, 'store']);

    Route::post('/follow/{id}', [FollowController::class, 'follow']);
    Route::post('/unfollow/{id}', [FollowController::class, 'unfollow']);

    Route::get('/users/{id}/followers', [FollowController::class, 'getFollowers']);
    Route::get('/users/{id}/following', [FollowController::class, 'getFollowing']);

    Route::get('/posts/following', [PostController::class, 'getPostFollowing']);

    Route::get('/users/{id}/profile', [UserController::class, 'showProfile']);

    Route::put('/users/image/upload', [UserController::class, 'uploadProfileImage']);

    Route::put('/users/{id}/profile', [UserController::class, 'updateProfile']);

    Route::get('/users/{id}/stats', [UserController::class, 'getFollowStats']);

    Route::put('/users/email', [UserController::class, 'changeEmail']);
    Route::put('/users/password', [UserController::class, 'changePassword']);

    Route::delete('/users/delete', [UserController::class, 'destroy']);

    Route::post('/posts/{id}/favorite', [FavoriteController::class, 'addFavorite']);
    Route::delete('/posts/{id}/favorite', [FavoriteController::class, 'removeFavorite']);
    Route::get('/posts/favorites', [FavoriteController::class, 'getFavorites']);

    Route::get('/posts/{id}', [PostController::class, 'show']);

    Route::post('/posts/{id}/like', [LikeController::class, 'addLike']);
    Route::delete('/posts/{id}/like', [LikeController::class, 'removeLike']);
    Route::get('/posts/{id}/likes', [LikeController::class, 'getLikes']);

    Route::get('/posts/{id}/comments', [CommentController::class, 'index']);
    Route::post('/posts/{id}/comment', [CommentController::class, 'store']);
    Route::delete('/posts/{id}/comment', [CommentController::class, 'destroy']);


    Route::get('/posts/category/{id}', [PostController::class, 'getPostByCategory']);
});


Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('/posts/mine/{id}', [PostController::class, 'getMyPosts']);
Route::get('/posts/exclude/{id}', [PostController::class, 'getAllPostsExclude']);
Route::get('/posts/all', [PostController::class, 'getAllPosts']);

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])
    ->name('password.email');


Route::post('/google/callback', [SocialAuthController::class, 'loginWithGoogle']);
Route::post('/facebook/callback', [SocialAuthController::class, 'loginWithFacebook']);

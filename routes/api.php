<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FcmController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\NotifyController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\EditorImageController;
use App\Http\Controllers\Api\LikeCommentController;
use App\Http\Controllers\Api\PasswordResetController;

// ---------------------------
// Rutas públicas (sin login)
// ---------------------------

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

// Social Auth
Route::post('/google/callback', [SocialAuthController::class, 'loginWithGoogle']);
Route::post('/facebook/callback', [SocialAuthController::class, 'loginWithFacebook']);

// Categorías
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// Posts públicos
Route::get('/posts/all', [PostController::class, 'getAllPosts']);
Route::get('/posts/exclude/{id}', [PostController::class, 'getAllPostsExclude']);

// Usuarios
Route::get('/users', [UserController::class, 'index']);

// ---------------------------
// Rutas protegidas (requieren login)
// ---------------------------

Route::middleware('auth:sanctum')->group(function () {

    // Autenticación y sesión
    Route::post('/logout', [LogoutController::class, 'logout']);

    // Notificaciones
    Route::get('/notifications', [NotifyController::class, 'index']);
    Route::post('/notifications/mark-read', [NotifyController::class, 'markRead']);
    Route::get('/notifications/count', [NotifyController::class, 'count']);

    // FCM (Firebase Cloud Messaging)
    Route::put('/update-device-token', [FcmController::class, 'updateDeviceToken']);
    Route::post('/send-fcm-notification', [FcmController::class, 'sendFcmNotification']);
    Route::post('/send-topic-notification', [FcmController::class, 'sendTopicNotification']);
    Route::post('/delete-device-token', [FcmController::class, 'deleteDeviceToken']);

    // Editor de imágenes
    Route::post('/editor/image/upload', [EditorImageController::class, 'upload']);

    // Gestión de Posts
    Route::post('/posts/create', [PostController::class, 'store']);
    Route::get('/posts/following', [PostController::class, 'getPostFollowing']);
    Route::get('/posts/search', [PostController::class, 'search']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::get('/posts/category/{id}', [PostController::class, 'getPostByCategory']);
    Route::get('/posts/mine/{id}', [PostController::class, 'getMyPosts']);

    // Likes en posts
    Route::post('/posts/{id}/like', [LikeController::class, 'addLike']);
    Route::delete('/posts/{id}/like', [LikeController::class, 'removeLike']);
    Route::get('/posts/{id}/likes', [LikeController::class, 'getLikes']);

    // Favoritos
    Route::post('/posts/{id}/favorite', [FavoriteController::class, 'addFavorite']);
    Route::delete('/posts/{id}/favorite', [FavoriteController::class, 'removeFavorite']);
    Route::get('/posts/favorites', [FavoriteController::class, 'getFavorites']);

    // Comentarios en posts
    Route::get('/posts/{id}/comments', [CommentController::class, 'index']);
    Route::post('/posts/{id}/comment', [CommentController::class, 'store']);
    Route::delete('/posts/{id}/comment', [CommentController::class, 'destroy']);

    // Likes en comentarios
    Route::post('/posts/comments/{id}/like', [LikeCommentController::class, 'addLike']);
    Route::delete('/posts/comments/{id}/like', [LikeCommentController::class, 'removeLike']);
    Route::get('/posts/comments/{id}/likes', [LikeCommentController::class, 'getLikes']);

    // Seguidores
    Route::post('/users/follow/{id}', [FollowController::class, 'follow']);
    Route::post('/users/unfollow/{id}', [FollowController::class, 'unfollow']);
    Route::get('/users/{id}/followers', [FollowController::class, 'getFollowers']);
    Route::get('/users/{id}/following', [FollowController::class, 'getFollowing']);

    // Perfil de usuario
    Route::put('/users/image/upload', [UserController::class, 'uploadProfileImage']);
    Route::get('/users/{id}/profile', [UserController::class, 'showProfile']);
    Route::put('/users/{id}/profile', [UserController::class, 'updateProfile']);
    Route::get('/users/{id}/stats', [UserController::class, 'getFollowStats']);

    // Configuración de usuario
    Route::put('/users/email', [UserController::class, 'changeEmail']);
    Route::put('/users/password', [UserController::class, 'changePassword']);
    Route::delete('/users/delete', [UserController::class, 'destroy']);
    Route::get('/users/search', [UserController::class, 'search']);
});

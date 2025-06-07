<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/.well-known/assetlinks.json', function () {
    return asset('.well-known/assetlinks.json');
});

Route::get('/download', function () {
    return view('download.index');
});

Route::get('/download/apk', function () {
    $filePath = storage_path('app/public/bloogol.apk');
    return response()->download($filePath, 'bloogol.apk');
});

Route::get('/post/{id}', function ($id) {
    $post = Post::findOrFail($id);
    return view('post.post_show', compact('post'));
});

Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [PasswordResetController::class, 'reset'])
    ->name('password.update');

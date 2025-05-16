<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function addFavorite($id)
    {
        $user = User::findOrFail(Auth::id());
        $post = Post::findOrFail($id);

        $user->favoritePosts()->attach($post->id);

        return response()->json([
            'message' => 'Post added to favorites',
        ], 200);
    }

    public function removeFavorite($id)
    {
        $user = User::findOrFail(Auth::id());

        $user->favoritePosts()->detach($id);

        return response()->json([
            'message' => 'Post removed from favorites',
        ], 200);
    }

    public function getFavorites()
    {
        $user = User::findOrFail(Auth::id());

        $favorites = $user->favoritePosts()
            ->with('user', 'category')
            ->get()
            ->makeHidden('pivot');

        return response()->json($favorites, 200);
    }
}

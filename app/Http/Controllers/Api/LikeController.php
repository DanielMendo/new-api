<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function addLike($id)
    {
        $user = User::findOrFail(Auth::id());
        $post = Post::findOrFail($id);

        $user->likePost()->attach($post->id);

        return response()->json([
            'message' => 'Like added to post',
        ], 200);
    }

    public function removeLike($id)
    {
        $user = User::findOrFail(Auth::id());

        $user->likePost()->detach($id);

        return response()->json([
            'message' => 'Like removed from post',
        ], 200);
    }

    public function getLikes($id)
    {
        $post = Post::findOrFail($id);

        $likes = $post->likedByUsers()->count();

        return response()->json([
            'likes' => $likes,
        ], 200);
    }
}

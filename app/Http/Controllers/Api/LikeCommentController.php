<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikeCommentController extends Controller
{
    public function addLike($id)
    {
        $user = User::findOrFail(Auth::id());
        $comment = Comment::findOrFail($id);

        $user->likeComment()->attach($comment->id);

        return response()->json([
            'message' => 'Like added to comment',
        ], 200);
    }

    public function removeLike($id)
    {
        $user = User::findOrFail(Auth::id());

        $user->likeComment()->detach($id);

        return response()->json([
            'message' => 'Like removed from comment',
        ], 200);
    }

    public function getLikes($id)
    {
        $comment = Comment::findOrFail($id);

        $likes = $comment->likedByUsers()->count();

        return response()->json([
            'likes' => $likes,
        ], 200);
    }
}

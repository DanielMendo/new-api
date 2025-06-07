<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\FcmNotificationService;
use App\Http\Controllers\Api\FcmController;
use App\Notifications\PostLikedNotification;

class LikeController extends Controller
{
    public function addLike($id, FcmController $notifier)
    {
        $user = User::findOrFail(Auth::id());
        $post = Post::findOrFail($id);
        $target = User::findOrFail($post->user_id);

        $user->likePost()->attach($post->id);

        if ($user->id != $post->user_id) {
            $notifier->sendLikeNotification($post, $user);
            $target->notify(new PostLikedNotification($post, $user));
        }

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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FollowController extends Controller
{
    public function follow($id)
    {
        $user = Auth::user();
        $target = User::findOrFail($id);

        $target->followers()->attach($user->id);

        return response()->json([
            'message' => 'Followed successfully',
        ], 200);
    }

    public function unfollow($id)
    {
        $user = Auth::user();
        $target = User::findOrFail($id);

        $target->followers()->detach($user->id);

        return response()->json([
            'message' => 'Unfollowed successfully',
        ], 200);
    }

    public function getFollowers($id)
    {
        $user = User::findOrFail($id);

        $followers = $user->followers()->get();

        return response()->json($followers, 200);
    }

    public function getFollowing($id)
    {
        $user = User::findOrFail($id);

        $following = $user->following()->get();

        return response()->json($following, 200);
    }
}

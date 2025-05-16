<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return response()->json(['message' => 'No hay usuarios'], 204);
        }
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $member = User::create($request->all());
        return response()->json($member, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user, 200);
    }

    public function showProfile($id)
    {
        $user = User::withCount(['followers', 'following'])->findOrFail($id);

        $authUser = User::findOrFail(Auth::id());

        $isFollowing = $authUser->following()->where('followed_id', $id)->exists();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'profile_image' => $user->profile_image,
            'followers_count' => $user->followers_count,
            'following_count' => $user->following_count,
            'is_following' => $isFollowing,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'bio' => $request->bio,
            'profile_image' => $request->profile_image,
        ]);

        $user->save();

        return response()->json($user, 200);
    }

    public function getFollowStats($id)
    {
        $authUser = User::findOrFail(Auth::id());
        $user = User::findOrFail($id);

        $followers = $user->followers;
        $following = $user->following;

        $isFollowing = $authUser->following()->where('followed_id', $user->id)->exists();

        return response()->json([
            'followers_count' => $followers->count(),
            'following_count' => $following->count(),
            'is_following' => $isFollowing,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ], 200);
    }

    public function uploadProfileImage(Request $request)
    {
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile', 'public');
            $url = Storage::url($path);

            $user = User::findOrFail(Auth::id());
            $user->profile_image = $path;
            $user->save();

            return response()->json([
                'path' => $path,
                'url' => asset($url),
            ], 200);
        }

        return response()->json(['message' => 'No file selected'], 400);
    }

    public function changeEmail(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $user->email = $request->email;
        $user->save();

        return response()->json([
            'message' => 'Email changed successfully',
        ], 200);
    }

    public function changePassword(Request $request)

    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password changed successfully',
        ], 200);
    }
}

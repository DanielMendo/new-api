<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getMyPosts($id)
    {
        $posts = Post::with('user')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts, 200);
    }

    public function getAllPostsExclude($id)
    {
        $posts = Post::with('user')
            ->where('user_id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts, 200);
    }

    public function getPostFollowing()
    {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id);

        $followedIds = $user->following()->pluck('users.id');

        $posts = Post::with('user')
            ->whereIn('user_id', $followedIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts, 200);
    }


    public function getAllPosts()
    {
        $posts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts, 200);
    }

    public function getPostByCategory($id)
    {
        $posts = Post::with('user')
            ->where('category_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($posts, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'category_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'html' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Post::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->content,
            'html' => $request->html,
            'image' => $request->image ?? null,
            'is_published' => $request->is_published,
        ]);

        return response()->json([
            'message' => 'Post creado exitosamente',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::with('user')
            ->findOrFail($id);

        return response()->json($post, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pub = Post::findOrFail($id);
        $pub->update($request->all());

        return response()->json($pub, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::destroy($id);
        return response()->json(null, 204);
    }
}

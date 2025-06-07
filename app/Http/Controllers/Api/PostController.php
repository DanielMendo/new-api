<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getMyPosts($id, Request $request)
    {
        $authUser = User::findOrFail(Auth::id());
        $visibility = $request->query('visibility');

        $query = Post::with('user')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc');

        if ($visibility == 'public') {
            $query->where('is_published', true);
        }

        if ($visibility == 'private') {
            $query->where('is_published', false);
        }

        if ($authUser->id != $id) {
            $query->where('is_published', true);
        }

        $posts = $query->get();

        return response()->json($posts, 200);
    }

    public function getAllPostsExclude($id)
    {
        $posts = Post::with('user')
            ->where('user_id', '!=', $id)
            ->where('is_published', true)
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
            ->where('is_published', true)
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
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($posts, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Datos recibidos en store:', $request->all());

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'category_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'html' => 'required',
            'image' => 'required|string',
            'image_urls' => 'required',
            'is_published' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $slug = Str::slug($request->title);

        Post::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'html' => $request->html,
            'image' => $request->image,
            'image_urls' => $request->image_urls,
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
            ->where('id', $id)
            ->orWhere('slug', $id)
            ->firstOrFail();

        return response()->json($post, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {

        $post = Post::findOrFail($id);

        $slug = Str::slug($request->title);

        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->slug = $slug;
        $post->content = $request->content;
        $post->html = $request->html;
        $post->image = $request->image;
        $post->image_urls = $request->image_urls;
        $post->is_published = $request->is_published;

        $post->save();

        return response()->json([
            'message' => 'Post updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::destroy($id);
        return response()->json([
            'message' => 'Post deleted successfully',
        ], 200);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::with('user')
            ->where('title', 'like', '%' . $query . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts, 200);
    }
}

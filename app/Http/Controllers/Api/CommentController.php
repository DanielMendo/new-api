<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($id)
    {
        $post = Post::findOrFail($id);

        $comments = $post->comments()->with(['user', 'replies.user'])
            ->whereNull('parent_id')
            ->get();

        return response()->json($comments, 200);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'parent_id' => 'nullable|integer',
            'content' => 'required|string|max:255',
        ]);

        $user = User::findOrFail(Auth::id());
        $post = Post::findOrFail($id);

        $post->comments()->create([
            'user_id' => $user->id,
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Comment created successfully',
        ], 201);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully',
        ], 200);
    }
}

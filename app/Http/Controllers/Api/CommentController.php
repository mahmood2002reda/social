<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $data = $request->validate(['content' => 'required|string']);
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $data['content'],
        ]);

        return response()->json(['message' => 'Comment added', 'comment' => $comment]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['message' => 'Comment deleted']);
    }
}

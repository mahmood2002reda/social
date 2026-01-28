<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Events\CommentAdded;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'content' => $data['content'],
            'user_id' => auth()->id(),
        ]);
        broadcast(new CommentAdded($comment))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment added successfully!',
            'comment' => [
                'user_name' => auth()->user()->name,
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
            ]
        ]);
    }
}
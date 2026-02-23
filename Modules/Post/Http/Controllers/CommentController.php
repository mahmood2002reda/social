<?php

namespace Modules\Post\Http\Controllers;

use App\Events\CommentAdded;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Post\Entities\Post;

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

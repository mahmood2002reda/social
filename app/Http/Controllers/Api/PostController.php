<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments', 'likes'])->latest()->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['content' => 'required|string']);
        $post = auth()->user()->posts()->create($data);

        return response()->json(['message' => 'Post created', 'post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate(['content' => 'required|string']);
        $post->update($data);

        return response()->json(['message' => 'Post updated', 'post' => $post]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }
}

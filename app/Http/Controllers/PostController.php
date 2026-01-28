<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments', 'likes'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'content' => 'required|string',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // التحقق من صحة الصور
    ]);

    $post = auth()->user()->posts()->create($request->only('content'));

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/posts'), $imageName);
            $post->images()->create(['image_path' => 'images/posts/' . $imageName]);
        }
    }

    return redirect()->route('posts.index');
}

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // التحقق من صحة الصور
        ]);
    
        $post->update($request->only('content'));
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/posts'), $imageName);
    
                $post->images()->create(['image_path' => 'images/posts/' . $imageName]);
            }
        }
    
        return redirect()->route('posts.index');
    }
    

    public function destroy(Post $post)
    {
        $post->delete();

        return back();
    }
}

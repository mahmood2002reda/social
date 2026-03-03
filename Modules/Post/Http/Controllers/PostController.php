<?php
namespace Modules\Post\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Post\Entities\Post;
use Modules\Post\Entities\User;
use Modules\Post\Services\PostService;

class PostController extends Controller
{
    public function __construct(private PostService $postService) {}

    public function index()
    {
        $user = User::find(auth()->id());
        $posts = $this->postService->getAllPosts();
        $my_friend =$this->postService->getAllFriends($user);
// foreach ($my_friend as $friendship) {
//    dd($friendship);
// }
            return view('posts.index', compact('posts' ,'my_friend','user'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $user = User::find(auth()->id());
        $this->postService->store($request,$user);

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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $this->postService->update($request, $post);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $this->postService->delete($post);
        return back();
    }
}
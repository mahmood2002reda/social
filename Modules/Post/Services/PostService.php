<?php
namespace Modules\Post\Services;

use Illuminate\Http\Request;
use Modules\Post\Entities\Post;
use Modules\Post\Repositories\PostRepositoryInterface;

class PostService
{
    public function __construct(private PostRepositoryInterface $postRepo) {}

    public function getAllPosts()
    {
        return $this->postRepo->all();
    }

    public function store(Request $request): Post
    {
        $post = $this->postRepo->create($request->only('content'));

        $this->uploadImages($request, $post);

        return $post;
    }

    public function update(Request $request, Post $post): Post
    {
        $this->postRepo->update($post, $request->only('content'));

        $this->uploadImages($request, $post);

        return $post;
    }

    public function delete(Post $post): bool
    {
        return $this->postRepo->delete($post);
    }

    private function uploadImages(Request $request, Post $post)
    {
        if (!$request->hasFile('images')) return;

        foreach ($request->file('images') as $image) {
            $name = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/posts'), $name);

            $post->images()->create([
                'image_path' => "images/posts/$name"
            ]);
        }
    }
}
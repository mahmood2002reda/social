<?php 

namespace Modules\Post\Repositories;

use Modules\Post\Entities\Post;

class PostRepository implements PostRepositoryInterface
{
    public function all()
    {
        return Post::with(['user', 'comments', 'likes', 'images'])
            ->latest()
            ->get();
    }

    public function create(array $data): Post
    {
        return auth()->user()->posts()->create($data);
    }

    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }
}
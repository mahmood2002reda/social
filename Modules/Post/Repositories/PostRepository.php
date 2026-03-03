<?php 

namespace Modules\Post\Repositories;

use Illuminate\Support\Facades\Auth;
use Modules\Post\Entities\Friendship;
use Modules\Post\Entities\Post;
use Modules\Post\Entities\User;

class PostRepository implements PostRepositoryInterface
{
    public function all()
    {
        return Post::with(['user', 'comments', 'likes', 'images'])
            ->latest()
            ->get();
    }
     public function allFrinds(User $user)
    {
                return $user->friends;

    }


    public function create(array $data ,User $user): Post
    {
        return $user->posts()->create($data);
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
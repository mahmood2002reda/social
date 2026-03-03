<?php
namespace Modules\Post\Repositories;

use Modules\Post\Entities\Post;

class LikeRepository implements LikeRepositoryInterface
{
    public function like(Post $post, int $userId)
    {
        return $post->likes()->create([
            'user_id' => $userId
        ]);
    }

    public function unlike(Post $post, int $userId)
    {
        return $post->likes()->where('user_id', $userId)->delete();
    }

    public function isLikedBy(Post $post, int $userId): bool
    {
        return $post->likes()->where('user_id', $userId)->exists();
    }

    public function countLikes(Post $post): int
    {
        return $post->likes()->count();
    }
}
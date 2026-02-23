<?php
namespace Modules\Post\Repositories;
use Modules\Post\Entities\Post;
interface LikeRepositoryInterface
{
    public function like(Post $post, int $userId);
    public function unlike(Post $post, int $userId);
    public function isLikedBy(Post $post, int $userId): bool;
    public function countLikes(Post $post): int;
}
<?php 
namespace Modules\Post\Services;

use App\Events\PostLiked;
use Modules\Post\Entities\Post;
use Modules\Post\Repositories\LikeRepositoryInterface;
use Exception;

class LikeService
{
    public function __construct(private LikeRepositoryInterface $likeRepo) {}

    public function like(Post $post)
    {
        $userId = auth()->id();

        if ($this->likeRepo->isLikedBy($post, $userId)) {
            return [
                'success' => false,
                'message' => 'You already liked this post.'
            ];
        }

        $this->likeRepo->like($post, $userId);

        $likesCount = $this->likeRepo->countLikes($post);

        try {
            event(new PostLiked($post, auth()->user(), $likesCount));
        } catch (Exception $e) {
            logger()->error($e->getMessage());
        }

        return [
            'success' => true,
            'liked' => true,
            'likes_count' => $likesCount
        ];
    }

    public function unlike(Post $post)
    {
        $userId = auth()->id();

        if (!$this->likeRepo->isLikedBy($post, $userId)) {
            return [
                'success' => false,
                'liked' => false,
                'likes_count' => $this->likeRepo->countLikes($post),
                'message' => 'Post already unliked'
            ];
        }

        $this->likeRepo->unlike($post, $userId);

        $likesCount = $this->likeRepo->countLikes($post);

        event(new PostLiked($post, auth()->user(), $likesCount));

        return [
            'success' => true,
            'liked' => false,
            'likes_count' => $likesCount
        ];
    }
}
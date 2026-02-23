<?php
namespace Modules\Post\Repositories;

use Modules\Post\Entities\Post;

class CommentRepository implements CommentRepositoryInterface
{
    public function create(Post $post, array $data)
    {
        return $post->comments()->create($data);
    }
}
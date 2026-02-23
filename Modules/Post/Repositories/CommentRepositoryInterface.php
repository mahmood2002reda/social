<?php
namespace Modules\Post\Repositories;

use Modules\Post\Entities\Post;

interface CommentRepositoryInterface
{
    public function create(Post $post, array $data);
}
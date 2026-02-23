<?php 
namespace Modules\Post\Repositories;

use Modules\Post\Entities\Post;

interface PostRepositoryInterface
{
    public function all();
    public function create(array $data): Post;
    public function update(Post $post, array $data): Post;
    public function delete(Post $post): bool;
}
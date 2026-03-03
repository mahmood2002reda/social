<?php 
namespace Modules\Post\Repositories;

use Modules\Post\Entities\Post;
use Modules\Post\Entities\User;

interface PostRepositoryInterface
{
    public function all();
    public function allFrinds(User $user);
    public function create(array $data, User $user): Post;
    public function update(Post $post, array $data): Post;
    public function delete(Post $post): bool;
}
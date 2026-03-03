<?php
namespace Modules\Friendship\Repositories;

use App\Models\User;
use Modules\Friendship\Entities\Friendship;

interface FriendshipRepositoryInterface
{
    public function createRequest(int $userId, int $friendId): Friendship;
    public function acceptRequest(Friendship $friendship): Friendship;
    public function rejectRequest(Friendship $friendship): bool;
    public function unfriend(int $userId, int $friendId): bool;
    public function cancelRequest(int $userId, int $friendId): bool;
    public function getFriendRequests(int $userId);
    public function getFriends(User $user);
    public function searchUsers(string $query, int $excludeUserId);
    public function getUserPosts(User $user);
}
<?php
namespace Modules\Friendship\Repositories;

use App\Models\User;
use Modules\Friendship\Entities\Friendship;

class FriendshipRepository implements FriendshipRepositoryInterface
{
    public function createRequest(int $userId, int $friendId): Friendship
    {
        return Friendship::create([
            'user_id' => $userId,
            'friend_id' => $friendId,
            'accepted' => false,
        ]);
    }

    public function acceptRequest(Friendship $friendship): Friendship
    {
        $friendship->update(['accepted' => true]);
        return Friendship::create([
            'user_id' => $friendship->friend_id,
            'friend_id' => $friendship->user_id,
            'accepted' => true,
        ]);
    }

    public function rejectRequest(Friendship $friendship): bool
    {
        return $friendship->delete();
    }

    public function unfriend(int $userId, int $friendId): bool
    {
        $friendship = Friendship::where(function ($q) use ($userId, $friendId) {
            $q->where('user_id', $userId)->where('friend_id', $friendId);
        })->orWhere(function ($q) use ($userId, $friendId) {
            $q->where('user_id', $friendId)->where('friend_id', $userId);
        })->first();

        return $friendship ? $friendship->delete() : false;
    }

    public function cancelRequest(int $userId, int $friendId): bool
    {
        $friendship = Friendship::where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->first();

        return $friendship ? $friendship->delete() : false;
    }

    public function getFriendRequests(int $userId)
    {
        return User::find($userId)->receivedFriendRequests()->where('accepted', false)->get();
    }

    public function getFriends(User $user)
    {
        return $user->friends;
    }

    public function searchUsers(string $query, int $excludeUserId)
    {
        return User::where('name', 'LIKE', "%{$query}%")
                   ->where('id', '!=', $excludeUserId)
                   ->get();
    }

    public function getUserPosts(User $user)
    {
        return $user->posts()->latest()->get();
    }
}
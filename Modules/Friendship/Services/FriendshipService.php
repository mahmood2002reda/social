<?php
namespace Modules\Friendship\Services;

use App\Models\User;
use Modules\Friendship\Entities\Friendship;
use Modules\Friendship\Repositories\FriendshipRepositoryInterface;

class FriendshipService
{
    public function __construct(private FriendshipRepositoryInterface $repo) {}

    public function sendRequest(User $user)
    {
        return $this->repo->createRequest(auth()->id(), $user->id);
    }

    public function acceptRequest(Friendship $friendship)
    {
        return $this->repo->acceptRequest($friendship);
    }

    public function rejectRequest(Friendship $friendship)
    {
        return $this->repo->rejectRequest($friendship);
    }

    public function unfriend(User $user)
    {
        return $this->repo->unfriend(auth()->id(), $user->id);
    }

    public function cancel(User $user)
    {
        return $this->repo->cancelRequest(auth()->id(), $user->id);
    }

    public function friendRequests()
    {
        return $this->repo->getFriendRequests(auth()->id());
    }

    public function friends(User $user)
    {
        return $this->repo->getFriends($user);
    }

    public function search(string $query)
    {
        return $this->repo->searchUsers($query, auth()->id());
    }

    public function show(User $user)
    {
        return $this->repo->getUserPosts($user);
    }
}
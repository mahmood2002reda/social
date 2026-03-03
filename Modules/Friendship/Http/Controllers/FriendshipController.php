<?php
namespace Modules\Friendship\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Friendship\Entities\Friendship;
use Modules\Friendship\Services\FriendshipService;

class FriendshipController extends Controller
{
    public function __construct(private FriendshipService $service) {}

    public function sendRequest(User $user)
    {
        $this->service->sendRequest($user);
        return back()->with('success', 'Friend request sent.');
    }

    public function acceptRequest(Friendship $friendship)
    {
        $this->service->acceptRequest($friendship);
        return back()->with('success', 'Friend request accepted. You are now friends.');
    }

    public function rejectRequest(Friendship $friendship)
    {
        $this->service->rejectRequest($friendship);
        return back()->with('success', 'Friend request rejected.');
    }

    public function unfriend(User $user)
    {
        $this->service->unfriend($user);
        return back()->with('success', 'Friendship removed.');
    }

    public function cancel(User $user)
    {
        $this->service->cancel($user);
        return back()->with('success', 'Friend request cancelled.');
    }

    public function friendRequests()
    {
        $friendRequests = $this->service->friendRequests();
        return view('friendship::friends.requests', compact('friendRequests'));
    }

    public function friends(User $user)
    {
        $friends = $this->service->friends($user);
        return view('friendship::friends.index', compact('friends', 'user'));
    }

    public function search(Request $request)
    {
        $users = $this->service->search($request->input('query'));
        return view('friendship::friends.search-results', compact('users'));
    }

    public function show(User $user)
    {
        $posts = $this->service->show($user);
        return view('friendship::friends.profile', compact('user', 'posts'));
    }
}
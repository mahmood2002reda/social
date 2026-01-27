<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    public function sendRequest(User $user)
    {
        $friendship = Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $user->id,
            'accepted' => false,
        ]);

        return response()->json(['message' => 'Friend request sent', 'friendship' => $friendship]);
    }

    public function acceptRequest(Friendship $friendship)
    {
        $friendship->update(['accepted' => true]);
        return response()->json(['message' => 'Friend request accepted']);
    }

    public function rejectRequest(Friendship $friendship)
    {
        $friendship->delete();
        return response()->json(['message' => 'Friend request rejected']);
    }

    public function listFriends(User $user)
    {
        $friends = $user->friends;
        return response()->json($friends);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    public function sendRequest(User $user)
    {
        Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $user->id,
            'accepted' => false,
        ]);

        return back()->with('success', 'Friend request sent.');
    }

   public function acceptRequest(Friendship $friendship)
   {
       // تحديث حالة طلب الصداقة الأصلي ليصبح مقبولاً (accepted = true)
       $friendship->update(['accepted' => true]);
   
       // إدخال صف جديد لعكس العلاقة بين الطرفين
       Friendship::create([
           'user_id' => $friendship->friend_id, // الطرف الذي قبل الطلب يصبح المرسل
           'friend_id' => $friendship->user_id, // الطرف الذي أرسل الطلب يصبح المستلم
           'accepted' => true, // الصداقة مقبولة
       ]);
   
       return back()->with('success', 'Friend request accepted. You are now friends.');
   }
   

    public function rejectRequest(Friendship $friendship)
    {
        $friendship->delete();

        return back()->with('success', 'Friend request rejected.');
    }

   

    public function friendRequests()
    {
        // Get all friend requests received by the authenticated user that are not yet accepted
        $friendRequests = auth()->user()->receivedFriendRequests()->where('accepted', false)->get();

        return view('friends.requests', compact('friendRequests'));
    }

    public function friends(User $user)
    {
        // جلب الأصدقاء المقبولين
        $friends = $user->friends;
        
        return view('friends.index', compact('friends', 'user'));
    }
    
    
    

    public function search(Request $request)
{
    $query = $request->input('query');

    // البحث عن المستخدمين بناءً على الاسم المدخل
    $users = User::where('name', 'LIKE', "%{$query}%")
                 ->where('id', '!=', auth()->id()) // استثناء المستخدم الحالي من النتائج
                 ->get();

    // تعديل مسار العرض إلى داخل مجلد friends
    return view('friends.search-results', compact('users'));
}


public function show(User $user)
{
    
    // الحصول على منشورات المستخدم
    $posts = $user->posts()->latest()->get();

    // تعديل مسار العرض إلى داخل مجلد friends
    return view('friends.profile', compact('user', 'posts'));
}
public function unfriend(User $user)
{
    // البحث عن الصداقة
    $friendship = Friendship::where(function ($query) use ($user) {
        $query->where('user_id', auth()->id())
              ->where('friend_id', $user->id);
    })->orWhere(function ($query) use ($user) {
        $query->where('user_id', $user->id)
              ->where('friend_id', auth()->id());
    })->first();

    if ($friendship) {
        $friendship->delete();
        return back()->with('success', 'Friendship removed.');
    }

    return back()->with('error', 'Friendship not found.');
}
public function cancel(User $user)
{
    // البحث عن طلب الصداقة المرسل
    $friendship = auth()->user()->sentFriendRequests()
        ->where('friend_id', $user->id)
        ->first();

    if ($friendship) {
        $friendship->delete(); // حذف طلب الصداقة
        return back()->with('success', 'Friend request cancelled.');
    }

    return back()->with('error', 'Friend request not found.');
}

}

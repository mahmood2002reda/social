<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // دالة لإضافة إعجاب على منشور
    public function like(Post $post)
    {
        // التحقق مما إذا كان المستخدم قد أعجب بالمنشور مسبقًا
        if ($post->isLikedBy(auth()->user())) {
            return back()->with('error', 'You already liked this post.');
        }

        // إنشاء إعجاب جديد
        $post->likes()->create([
            'user_id' => auth()->id(),
        ]);

        return back()->with('status', 'Post liked!');
    }

    // دالة لإلغاء الإعجاب بمنشور
    public function unlike(Post $post)
    {
        // التحقق مما إذا كان المستخدم قد أعجب بالمنشور مسبقًا
        if (!$post->isLikedBy(auth()->user())) {
            return back()->with('error', 'You have not liked this post yet.');
        }

        // حذف الإعجاب
        $post->likes()->where('user_id', auth()->id())->delete();

        return back()->with('status', 'Like removed!');
    }
}

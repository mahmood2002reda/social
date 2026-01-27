<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // دالة لإضافة تعليق جديد على منشور
    public function store(Request $request, Post $post)
    {
        // التحقق من صحة البيانات
        $data = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // إضافة التعليق وربطه بالمستخدم الحالي والمنشور
        $post->comments()->create([
            'content' => $data['content'],
            'user_id' => auth()->id(),
        ]);

        return back()->with('status', 'Comment added successfully!');
    }
}

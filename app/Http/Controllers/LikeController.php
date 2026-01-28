<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Events\PostLiked;
use Exception;
use Illuminate\Http\Request;

class LikeController extends Controller
{
   public function like(Post $post)
{
    if ($post->isLikedBy(auth()->user())) {
        return response()->json([
            'success' => false,
            'message' => 'You already liked this post.'
        ], 400);
    }

    $post->likes()->create([
        'user_id' => auth()->id(),
    ]);
    
    $likesCount = $post->likes()->count();
    try{
    event(new PostLiked($post, auth()->user(), $likesCount));

    }
catch(Exception $e)
{
    dd($e->getMessage());
}
    return response()->json([
        'success' => true,
        'message' => 'Post liked!',
          'liked' => true,
        'likes_count' => $likesCount
    ]);
}

   public function unlike(Post $post)
{
    if (!$post->isLikedBy(auth()->user())) {
        return response()->json([
            'liked' => false,
            'likes_count' => $post->likes()->count(),
            'message' => 'Post already unliked'
        ], 400);
    }

    $post->likes()->where('user_id', auth()->id())->delete();

    $likesCount = $post->likes()->count();

    event(new PostLiked($post, auth()->user(), $likesCount));

    return response()->json([
        'liked' => false,          
        'likes_count' => $likesCount
    ]);
}

}

<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use App\Models\User;

class PostLiked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;
    public $user;
    public $likesCount;

    public function __construct(Post $post, User $user, $likesCount)
    {
        $this->post = $post;
        $this->user = $user;
        $this->likesCount = $likesCount;
    }

    public function broadcastOn()
    {
        return new Channel('posts.' . $this->post->id);
    }

    public function broadcastWith()
    {
        return [
            'post_id' => $this->post->id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->profile?->profile_picture ? asset($this->user->profile->profile_picture) : 'https://via.placeholder.com/40',
            'likes_count' => $this->likesCount,
        ];
    }
}
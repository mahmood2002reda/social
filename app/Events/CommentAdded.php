<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;

class CommentAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function broadcastOn()
    {
        return new Channel('posts.' . $this->comment->post_id);
    }

    public function broadcastWith()
    {
        return [
            'post_id' => $this->comment->post_id,
            'comment_id' => $this->comment->id,
            'user_name' => $this->comment->user->name,
            'user_avatar' => $this->comment->user->profile?->profile_picture ? asset($this->comment->user->profile->profile_picture) : 'https://via.placeholder.com/40',
            'content' => $this->comment->content,
            'created_at' => $this->comment->created_at->diffForHumans(),
        ];
    }
}
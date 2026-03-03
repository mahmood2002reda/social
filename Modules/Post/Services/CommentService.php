<?php
namespace Modules\Post\Services;

use App\Events\CommentAdded;
use Modules\Post\Entities\Post;
use Modules\Post\Repositories\CommentRepositoryInterface;

class CommentService
{
    public function __construct(private CommentRepositoryInterface $commentRepo) {}

    public function store(Post $post, array $data)
    {
        $comment = $this->commentRepo->create($post, [
            'content' => $data['content'],
            'user_id' => auth()->id(),
        ]);

        // Broadcast event
        broadcast(new CommentAdded($comment))->toOthers();

        return [
            'status' => 'success',
            'message' => 'Comment added successfully!',
            'comment' => [
                'user_name' => auth()->user()->name,
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
            ]
        ];
    }
}
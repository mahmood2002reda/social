<?php
namespace Modules\Post\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Post\Entities\Post;
use Modules\Post\Services\CommentService;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService) {}

    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $response = $this->commentService->store($post, $data);

        return response()->json($response);
    }
}
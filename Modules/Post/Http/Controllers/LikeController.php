<?php
namespace Modules\Post\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Post\Entities\Post;
use Modules\Post\Services\LikeService;

class LikeController extends Controller
{
    public function __construct(private LikeService $likeService) {}

    public function like(Post $post)
    {
        $response = $this->likeService->like($post);
        return response()->json($response, $response['success'] ? 200 : 400);
    }

    public function unlike(Post $post)
    {
        $response = $this->likeService->unlike($post);
        return response()->json($response, $response['success'] ? 200 : 400);
    }
}
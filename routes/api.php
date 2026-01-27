<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\FriendshipController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile/{user}', [ProfileController::class, 'show']);
    Route::patch('profile/{user}', [ProfileController::class, 'update']);

    Route::get('posts', [PostController::class, 'index']);
    Route::post('posts', [PostController::class, 'store']);
    Route::patch('posts/{post}', [PostController::class, 'update']);
    Route::delete('posts/{post}', [PostController::class, 'destroy']);

    Route::post('posts/{post}/comments', [CommentController::class, 'store']);
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);

    Route::post('posts/{post}/like', [LikeController::class, 'like']);
    Route::post('posts/{post}/unlike', [LikeController::class, 'unlike']);

    Route::post('friend-requests/{user}', [FriendshipController::class, 'sendRequest']);
    Route::post('friend-requests/{friendship}/accept', [FriendshipController::class, 'acceptRequest']);
    Route::post('friend-requests/{friendship}/reject', [FriendshipController::class, 'rejectRequest']);
    Route::get('friends/{user}', [FriendshipController::class, 'listFriends']);
});

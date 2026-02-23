<?php

use App\Http\Controllers\FriendshipController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\PostController;
use Modules\Post\Http\Controllers\ProfileController;
use Modules\Post\Http\Controllers\LikeController;
use Modules\Post\Http\Controllers\CommentController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('posts')->group(function() {
    Route::get('/', 'PostController@index');
    Route::resource('posts', PostController::class);
Route::post('{post}/like', [LikeController::class, 'like'])->name('post.like');
Route::post('{post}/unlike', [LikeController::class, 'unlike'])->name('post.unlike');
////////////
Route::post('{post}/comment', [CommentController::class, 'store'])->name('post.comment');

});

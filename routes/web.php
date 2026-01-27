<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendshipController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');

Route::get('/profile/{user:name}', [ProfileController::class, 'show'])->name('myprofile.show')->middleware('ownsProfile');
Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');


///////
Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('post.like');
Route::post('/posts/{post}/unlike', [LikeController::class, 'unlike'])->name('post.unlike');
////////////
Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('post.comment');

/////
//Route::get('/friends/{user:name}', [FriendshipController::class, 'friends'])->name('friends.list');

Route::post('/friend/{user}/request', [FriendshipController::class, 'sendRequest'])->name('friend.request');
Route::post('/friend/{friendship}/accept', [FriendshipController::class, 'acceptRequest'])->name('friend.accept');
Route::post('/friend/{friendship}/reject', [FriendshipController::class, 'rejectRequest'])->name('friend.reject');
Route::get('/friends/{user:name}', [FriendshipController::class, 'friends'])->name('friends.list');

Route::get('/friend-requests', [FriendshipController::class, 'friendRequests'])->name('friend.requests');
Route::get('/search', [FriendshipController::class, 'search'])->name('friend.search');
Route::get('/friend/profile/{user}', [FriendshipController::class, 'show'])->name('profile.show');
Route::post('/friend/{user}/unfriend', [FriendshipController::class, 'unfriend'])->name('friend.unfriend');
Route::post('/friend/{user}/cancel', [FriendshipController::class, 'cancel'])->name('friend.cancel');

Route::get('/search', [FriendshipController::class, 'search'])->name('friend.search');

// مسار عرض الملف الشخصي
//Route::get('/profile/{user}', [FriendshipController::class, 'show'])->name('profile.show');

// مسار إرسال طلب الصداقة
Route::post('/send-friend-request/{user}', [FriendshipController::class, 'sendRequest'])->name('friend.request');
// إرسال طلب صداقة
Route::post('/send-friend-request/{user}', [FriendshipController::class, 'sendRequest'])->name('friend.request');
////

Route::resource('posts', PostController::class);

Route::get('/friend-requests', [FriendshipController::class, 'friendRequests'])->name('friend.requests');

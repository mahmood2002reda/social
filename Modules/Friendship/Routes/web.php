<?php

use Modules\Friendship\Http\Controllers\FriendshipController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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

Route::prefix('friendship')->group(function() {
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


Route::get('/friend-requests', [FriendshipController::class, 'friendRequests'])->name('friend.requests');
});

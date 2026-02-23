<?php

use Modules\Profile\Http\Controllers\ProfileController;
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

Route::prefix('profile')->group(function() {
  Route::get('/create', [ProfileController::class, 'create'])->name('profile.create');
Route::post('/', [ProfileController::class, 'store'])->name('profile.store');

Route::get('/{user:name}', [ProfileController::class, 'show'])->name('myprofile.show')->middleware('ownsProfile');
Route::get('/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/{user}', [ProfileController::class, 'update'])->name('profile.update');


});


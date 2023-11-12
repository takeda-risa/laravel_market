<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LikeController;


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

Route::get('/', [ItemController::class, 'index'])->name('index');

Auth::routes();


/*-- item --*/
Route::resource('items', ItemController::class);
Route::get('/items/{item}/confirm', [ItemController::class, 'confirm'])->name('items.confirm');
Route::post('/items/{item}/finish', [ItemController::class, 'finish'])->name('items.finish');

Route::get('/items/{item}/edit_image', [ItemController::class, 'editImage'])->name('items.edit_image');
Route::patch('/items/{item}/edit_image', [ItemController::class, 'updateImage'])->name('items.update_image');


/*-- user --*/
Route::controller(UserController::class)->group(function () { 
    Route::get('/profile/edit',  'edit')->name('profile.edit');
    Route::patch('/profile', 'update')->name('profile.update');
    Route::get('/profile/edit_image', 'editImage')->name('profile.edit_image');
    Route::patch('/profile/edit_image', 'updateImage')->name('profile.update_image');
    Route::resource('users', UserController::class)->only([
        'show', 
    ]);
});
Route::get('users/{user}/exhibitions', [UserController::class, 'exhibitions'])->name('users.exhibitions');


/*-- like --*/
Route::resource('likes', LikeController::class)->only([
  'index', 'store', 'destroy'
]);
Route::patch('/items/{item}/toggle_like', [ItemController::class, 'toggleLike'])->name('items.toggle_like');


/*-- order --*/
Route::patch('/items/{item}/toggle_order', [ItemController::class, 'toggleOrder'])->name('items.toggle_order');

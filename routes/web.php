<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'WishListController@index');
Route::resource('wishlist','WishListController')->only(['store','update','destroy','show']);

Route::resource('wishlist_items','WishlistItemController')->only(['store','update','destroy']);

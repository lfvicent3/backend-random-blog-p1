<?php

use App\Http\Controllers\PostsController;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('post/add',  [PostsController::class, 'store'])->name('posts.store');
Route::get('post/all',   [PostsController::class, 'index'])->name('posts.index');
Route::get('post/{id}',  [PostsController::class, 'show' ])->name('posts.show');
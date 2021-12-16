<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Models\User;

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

Route::get('/comments', [CommentController::class, 'apiIndex'])->name('api.comments.index');
Route::get('/comments/{id}', [CommentController::class, 'apiSpecific'])->name('api.comments.specific');
Route::post('/comment/store', [CommentController::class, 'apiStore'])->name('api.comments.store');

Route::get('/posts', [PostController::class, 'apiIndex'])->name('api.posts.index');
Route::get('/posts/{id}', [PostController::class, 'apiSpecific'])->name('api.posts.specific');
Route::post('/posts/store', [PostController::class, 'apiStore'])->name('api.posts.store');
Route::post('/posts/edit', [PostController::class, 'apiEdit'])->name('api.posts.edit');

Route::get('/images/{filename}', function() {
    $filename = Route::input('filename');
    $i = Storage::disk('public')->get('images/'.$filename);
    return $i;
})->name('api.images.specific');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



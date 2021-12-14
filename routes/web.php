<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/post/{id}', [PostController::class, 'show'])->middleware(['auth'])->name('/post/{id}');;
Route::post('/comments', [CommentController::class, 'apiStore'])->name('api.comments.store');
Route::post('/posts', [PostController::class, 'apiStore'])->name('api.post.store');
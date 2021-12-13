<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class PostController extends Controller
{
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $name = User::findOrFail($post->user_id)->name;
        $comments = Comment::where('post_id', $id)->get();

        return view('layouts.post', ['post' => $post, 'name' => $name, 'comments' => $comments]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{

    public function apiIndex()
    {
        $posts = Post::all();
        return $posts;
    }

    public function apiSpecific($id)
    {
        $post = Post::where('id', $id)->first();
        return $post;
    }

    public function apiStore(Request $request)
    {
        $p = new Post();
        $p->user_id = Auth::id();
        $p->text = $request['text'];
        $p->date_posted = date('Y-m-d H:i:s');
        $p->save();
        return $p;
    }

    // public function show($id)
    // {
    //     $post = Post::findOrFail($id);

    //     return view('layouts.post', ['post' => $post]);
    // }
}
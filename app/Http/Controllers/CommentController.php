<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function apiIndex()
    {
        $comments = Comment::all();
        return $comments;
    }

    public function apiSpecific($id)
    {
        $comments = Comment::where('post_id', $id)->get();
        return $comments;
    }

    public function apiStore(Request $request){
        $c = new Comment();
        $c->post_id = $request['post_id'];
        $c->user_id = Auth::id();
        $c->text = $request['text'];
        $c->date_posted = date('Y-m-d H:i:s');
        $c->save();
        return $c;
    }
}
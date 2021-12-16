<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

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
        foreach($comments as $comment) {
            $comment['name'] = User::findOrFail($comment->user_id)->name;
        }
        
        return $comments;
    }

    public function apiStore(Request $request){

        $validated = $request->validate([
            'text' => 'required|max:500',
            'post_id' => 'required|exists:App\Models\Post,id',
            'user_id' => 'required|exists:App\Models\User,id',
        ]);

        $c = new Comment();
        $c->post_id = $validated['post_id'];
        $c->user_id = $validated['user_id'];
        $c->text = $validated['text'];
        $c->date_posted = date('Y-m-d H:i:s');
        $c->save();

        $c['name'] = User::findOrFail($c->user_id)->name;

        return $c;
    }
}
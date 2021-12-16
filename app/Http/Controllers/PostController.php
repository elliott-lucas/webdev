<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{

    public function apiIndex()
    {
        $posts = Post::all();
        foreach($posts as $post) {
            $post['name'] = User::findOrFail($post->user_id)->name;
        }

        return $posts;
    }

    public function apiSpecific($id)
    {
        $post = Post::where('id', $id)->first();
        $post['name'] = User::findOrFail($post->user_id)->name;
        return $post;
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|max:500',
            'image' => 'nullable|mimes:jpg,png',
            'user_id' => 'required|exists:App\Models\User,id',
        ]);

        $p = new Post();
        $p->user_id = $request['user_id'];
        $p->text = $validated['text'];

        if ($request['image']) {
            $validated['image']->store('images', 'public');
            $p->image_path = $validated['image']->hashName();
        } else {
            $p->image_path = null;
        }
        
        $p->date_posted = date('Y-m-d H:i:s');
        $p->save();

        $p['name'] = User::findOrFail($p->user_id)->name;

        return $p;
    }

    public function apiEdit(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|max:500',
            'post_id' => 'required|exists:App\Models\Post,id',
            'user_id' => 'required|exists:App\Models\User,id',
        ]);

        $p = Post::where('id', $validated['post_id'])->first();

        if ($p->user_id == $validated['user_id']) 
        {
            $p->text = $validated['text'];
        }

        $p->save();
        return $p;
    }

    public function show($id)
    {
        return view('layouts.post', ['id' => $id]);
    }
}
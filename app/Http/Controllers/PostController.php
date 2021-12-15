<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $validated = $request->validate([
            'text' => 'required|max:500',
            'image'=> 'nullable|mimes:jpg,png',
        ]);



        $p = new Post();
        $p->user_id = Auth::id();
        $p->text = $validated['text'];

        if ($request['image']) {
            $validated['image']->store('images', 'public');
            $p->image_path = $validated['image']->hashName();
        } else {
            $p->image_path = null;
        }
        
        $p->date_posted = date('Y-m-d H:i:s');
        $p->save();
        return $p;
    }

    public function apiEdit(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|max:500',
            'post_id' => 'required',
        ]);

        $p = Post::where('id', $validated['post_id'])->first();

        if ($p->user_id == Auth::id()) 
        {
            $p->text = $validated['text'];
        } else {
            $p->text = "LOL";
        }

        $p->save();
        return $p;
    }

    public function show($id)
    {
        return view('layouts.post', ['id' => $id]);
    }
}
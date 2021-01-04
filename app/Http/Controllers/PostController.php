<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {

        $posts = Post::orderBy('created_at', 'desc')->with('user', 'likes')->paginate(5);
        
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request) {
        //validate
        $this->validate($request, [
            'body' => 'required|max:255'
        ]);

        //store
        $request->user()->posts()->create([
            'body' => $request->body
        ]);

        //redirect
        return back();
    }

    public function destroy(Post $post) {

        $post->delete();

        return back();

    }

}

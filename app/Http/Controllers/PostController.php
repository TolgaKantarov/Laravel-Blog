<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->only('store', 'destroy');
    }

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

    public function show(Post $post) {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function destroy(Post $post) {

        $this->authorize('delete', $post);

        $post->delete();

        return back();

    }

}

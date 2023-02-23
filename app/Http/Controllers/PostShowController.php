<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostShowController extends Controller
{
    public function index()
    {
        return view('post.show.index',[
            'posts' => Post::all()
        ]);
    }
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('post.show.detail', compact('post'));
    }

}

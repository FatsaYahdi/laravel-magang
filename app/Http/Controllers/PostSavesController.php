<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostSaves;
use App\Models\User;
use Illuminate\Http\Request;

class PostSavesController extends Controller
{
    public function show($post)
    {
        $postsaves = PostSaves::where('user_id', $post)->get();
        foreach ($postsaves as $ps) {
            $post = Post::findOrFail($ps->post_id);
            $ps->post = $post;
        }
        return view('post.show.saved', compact('postsaves'));
    }

    public function store(Post $post)
    {
        $user = auth()->user();
        $user->postSaves()->create([
            'post_id' => $post->id,
        ]);
        return redirect()->back();
    }

    public function destroy(Post $post)
    {
        PostSaves::where('post_id', $post->id)->delete();
        return redirect()->back();
    }
}

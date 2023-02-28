<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostShowController extends Controller
{
    public function index(Request $request)
    {
        return view('post.show.index',[
            'pinnedPosts' => Post::latest()->where('is_pinned',true)->get(),
            'posts' => Post::latest()->paginate(6),
            'tags' => Tag::all()
        ]);
    }
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->with('tags', 'categories')->firstOrFail();
        $comments = Comment::where('post_id', $post->id)->with('user')->get();
        return view('post.show.detail', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|min:3|max:255',
        ]);
        Comment::create($data);
        return redirect()->back();
    }

    public function showCategory(Category $category) {
        $tags = Tag::all();
        $posts = $category->categories()->paginate(4);
        $pinnedPosts = $category->categories()->where('is_pinned',true)->get()->all();
        return view('post.show.index',compact(['posts','pinnedPosts','tags']));
    }

    public function showTag(Tag $tag) {
        $tags = Tag::all();
        $posts = $tag->tags()->paginate(4);
        $pinnedPosts = $tag->tags()->where('is_pinned',true)->get()->all();
        return view('post.show.index',compact(['posts','pinnedPosts','tags']));
    }

}

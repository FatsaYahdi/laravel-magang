<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostSaves;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $post = Post::where('slug', $slug)->with(['tags', 'categories'])->firstOrFail();
        $postId = $post->id;
        $like = Like::where('post_id',$post->id)->count();
        $widget = \Share::currentPage()
        ->facebook();
        $views = session()->get('post_views', []);
        if (!in_array($postId, $views)) {
            $post->increment('views');
            $views[] = $postId;
            session()->put('post_views', $views);
        }
        $post = $post->fresh();
        $comments = Comment::where('post_id', $post->id)->with('user')->get();
        return view('post.show.detail', [
            'post' => $post,
            'comments' => $comments,
            'like' => $like,
            'share' => $widget
        ]);
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|min:3|max:255',
            'parent_id' => 'nullable|exists:comments,id',
        ]);
        $comment = Comment::create($data);

        if ($data['parent_id']) {
            $parentComment = Comment::find($data['parent_id']);
            $parentComment->replies()->save($comment);
        }
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

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|min:3|max:255',
        ]);
        $comment = Comment::findOrFail($id);
        $comment->update($data);
        return redirect()->back();
    }

    public function delete($comment)
    {
        Comment::destroy($comment);
        return redirect()->back();
    }
}

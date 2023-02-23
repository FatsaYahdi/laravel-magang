<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return view('post.index');
    }
    public function list(Request $req)
    {
        return datatables()
            ->eloquent(Post::query()->latest()
            ->when(!$req->order, function ($query) {
                $query->latest();
            }))
            ->editColumn('action', function ($post) {
                return '
                <div class="d-flex">
                <form onsubmit="destroy(event)" action="' . route('post.destroy', $post->id) . '" method="POST">
                    <input type="hidden" name="_token" value="' . @csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-sm btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
                
                <a href="' . route('post.edit', $post->id) . '" class="btn btn-sm btn-info mx-2">
                    <i class="fa fa-pen"></i>
                </a>
                </div>
                ';
            })
            ->editColumn('title', function ($post) {
                return $post->title;
            })
            ->editColumn('created_by', function ($post) {
                return $post->created_by;
            })
            ->addIndexColumn()
            ->escapeColumns(['action'])
            ->toJson();
    }

    public function create()
    {
        return view('post.create',[
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'string|required|min:3',
            'image' => 'required',
            'content' => 'required',
        ]);
        $fileName = $request->file('image')->getClientOriginalName();
        $request->image->storeAs('public/images/posts/', $fileName);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $fileName,
            'created_by' => Auth::user()->name,
        ];
        $post = Post::create($data);
        $post->tags()->sync($request->input('tags' ,[]));
        $post->categories()->sync($request->input('categories' ,[]));
        return redirect('/post')->with('success','Post Berhasil dibuat.');
    }

    public function edit($id)
    {
        return view('post.edit', [
            'post' => Post::find($id),
            'tags' => Tag::all(),
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $find = Post::find($post->id);
        $request->validate([
            'title' => 'string|required|min:3',
            'image' => 'nullable',
            'content' => 'string|min:8',
        ]);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'created_by' => Auth::user()->name,
        ];
        if ($request->hasFile('image')) {
            $post = $request->file('image');
            $imgName = $post->getClientOriginalName();
            $post->storeAs('public/images/posts/', $imgName);
            if ($find->image !== null) {
                Storage::delete('public/images/posts/' . $find->image);
            }
            $data['image'] = $imgName;
        } else {
            $data['image'] = $find->image;
        }
        $find->update($data);
        $post->tags()->sync($request->input('tags', []));
        $post->categories()->sync($request->input('categories', []));
        return redirect('/post')->with('success','Post Berhasil Di Update.');
    }

    public function destroy(Post $post)
    {
        Storage::delete('public/images/posts/' . $post->image);
        $post->tags()->detach();
        $post->categories()->detach();
        $post->delete();
        return redirect('/post')->with('success','Post Berhasil Dihapus.');
    }
}

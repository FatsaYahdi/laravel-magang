<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        return view('post.index');
    }
    public function list()
    {
        return datatables()
            ->eloquent(Post::query()->latest())
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
        return view('post.create');
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
            'content' => $request->content,
            'created_by' => Auth::user()->name,
            'image' => $fileName
        ];
        $post = Post::create($data);
        return redirect('/post')->with('success','Post Berhasil dibuat.');
    }

    

    public function edit($id)
    {
        $post = Post::find($id);
        return view('post.edit',compact('post'));
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
        return redirect('/post')->with('success','Post Berhasil Di Update.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        Storage::delete('public/images/posts/' . $post->image);
        return redirect('/post')->with('success','Post Berhasil Dihapus.');
    }
}

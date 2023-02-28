<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function index()
    {
        return view('tag.index');
    }
    public function list(Request $req)
    {
        return datatables()
            ->eloquent(Tag::query()->latest()
            ->when(!$req->order, function ($query) {
                $query->latest();
            }))
            ->addColumn('action', function ($tag) {
                return '
                <div class="d-flex">
                <form onsubmit="destroy(event)" action="' . route('tag.destroy', $tag->id) . '" method="POST">
                    <input type="hidden" name="_token" value="' . @csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-sm btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
                
                <a href="' . route('tag.edit', $tag->id) . '" class="btn btn-sm btn-info mx-2">
                    <i class="fa fa-pen"></i>
                </a>
                </div>
                ';
            })
            ->editColumn('tag', function ($user) {
                return $user->tag;
            })
            ->editColumn('created_by', function ($user) {
                return $user->created_by;
            })
            ->addIndexColumn()
            ->escapeColumns(['action'])
            ->toJson();
    }

    public function create()
    {
        return view('tag.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'tag' => 'string|required|min:3',
            'description' => 'string|nullable',
        ]);
        $data = [
            'tag' => $request->tag,
            'description' => $request->description,
            'created_by' => Auth::user()->name,
        ];
        $tag = Tag::create($data);
        return redirect('/tag')->with('success','Tag Berhasil dibuat.');
    }

    

    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('tag.edit',compact('tag'));
    }

    
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'tag' => 'required|string',
            'description' => 'nullable|string'
        ]);
        $data = [
            'tag' => $request->tag,
            'description' => $request->description,
            'created_by' => $request->created_by
        ];
        $find = Tag::find($tag->id);
        $find->update($data);
        return redirect('/tag')->with('success','Tag Berhasil Di Update.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(['success' => 'Tag Berhasil Di Hapus.']);
    }
}

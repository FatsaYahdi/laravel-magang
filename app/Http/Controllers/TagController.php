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
    public function list()
    {
        return datatables()
            ->eloquent(Tag::query()->latest())
            ->addColumn('action', function ($tag) {
                return '
                <div class="d-flex">
                <form action="' . route('tag.destroy', $tag->id) . '" method="POST">
                    <input type="hidden" name="_token" value="' . @csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah anda yakin ingin menghapus?\');">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
                
                <a href="' . route('tag.edit', $tag->id) . '" class="btn btn-sm btn-info mx-2">
                    <i class="fa fa-pen"></i>
                </a>
                </div>
                ';
            })
            ->addColumn('name', function ($users) {
                return $users->tag;
            })
            ->addColumn('created_by', function ($users) {
                return $users->created_by;
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
            'tag' => 'string',
        ]);
        $data = [
            'tag' => $request->tag,
            'created_by' => Auth::user()->name,
        ];
        $tag = Tag::create($data);
        // dd($data);
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
            'tag' => 'required|string'
        ]);
        $data = [
            'tag' => $request->tag,
            'created_by' => $request->created_by
        ];
        $find = Tag::find($tag->id);
        $find->update($data);
        return redirect('/tag')->with('success','Tag Berhasil Di Update.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect('/tag')->with('success','Tag Berhasil Dihapus.');
    }
}

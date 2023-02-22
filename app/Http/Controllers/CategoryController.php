<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }
    public function list(Request $req)
    {
        return datatables()
            ->eloquent(Category::query()
            ->when(!$req->order, function ($query) {
                $query->latest();
            }))
            ->addColumn('action', function ($category) {
                return '
                <div class="d-flex">
                <form onsubmit="destroy(event)" action="' . route('category.destroy', $category->id) . '" method="POST">
                    <input type="hidden" name="_token" value="' . @csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-sm btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
                
                <a href="' . route('category.edit', $category->id) . '" class="btn btn-sm btn-primary mx-2">
                    <i class="fa fa-pen"></i>
                </a>
                </div>
                ';
            })
            ->editColumn('category', function ($user) {
                return $user->category;
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
        return view('category.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'string|required|min:3',
            'description' => 'string|nullable',
        ]);
        $data = [
            'category' => $request->category,
            'created_by' => Auth::user()->name,
            'description' => $request->description,
        ];
        $category = Category::create($data);
        return redirect('/category')->with('success','Category Berhasil dibuat.');
    }

    

    public function edit($id)
    {
        $category = Category::find($id);
        return view('category.edit',compact('category'));
    }

    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $data = [
            'category' => $request->category,
            'created_by' => $request->created_by,
            'description' => $request->description
        ];
        $find = Category::find($category->id);
        $find->update($data);
        return redirect('/category')->with('success','Category Berhasil Di Update.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/category')->with('success','Category Berhasil Dihapus.');
    }
}

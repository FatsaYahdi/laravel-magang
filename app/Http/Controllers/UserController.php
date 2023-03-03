<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function list()
    {
        return datatables()
            ->eloquent(User::query()->where('role','!=','superadmin')->latest())
            ->addColumn('action', function ($user) {
                return '
                <div class="d-flex">
                <form onsubmit="destroy(event)" action="' . route('user.delete', $user->id) . '" method="POST">
                    <input type="hidden" name="_token" value="' . @csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-sm btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
                
                <a href="' . route('show.show', $user->id) . '" class="btn btn-sm btn-info mx-2">
                    <i class="fa fa-pen"></i>
                </a>
                </div>
                ';
            })
            ->addColumn('pp', function ($user) {
                return $user->pp
                    ? '<img src="' . asset('/storage/images/' . $user->pp) . '" width="50px" class="rounded-circle">'
                    : '<img src="' . asset('/images/null.jfif') . '" width="50px" class="rounded-circle">';
            })
            ->addColumn('status', function ($user) {
                $status =  ($user->status =='active' ) ? 'Active' : 'Blocked';
                $class = ($user->status =='active' ) ? 'badge-success' : 'badge-danger';
                return '<span class="badge ' . $class . '">' . $status . '</span>';
            })
            ->editColumn('role', function ($user) {
                return $user->role;
            })
            ->addIndexColumn()
            ->escapeColumns(['action'])
            ->toJson();
    }

    public function index()
    {
        return view('user.index');
    }

    public function delete(User $user)
    {
        Storage::delete('public/images/',$user->pp);
        $user->delete();
        return response()->json(['success' => 'User Telah Berhasil Di Hapus!']);
    }

    public function create() {
        return view('user.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|min:3|unique:users',
            'email' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];
        User::create($data);
        return redirect('/user')->with('success','User Telah Di Buat.');
    }
}
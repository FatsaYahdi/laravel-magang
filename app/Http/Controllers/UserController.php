<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function list()
    {
        return datatables()
            ->eloquent(User::query()->where('role','!=','superadmin')->latest())
            ->addColumn('action', function ($user) {
                return '
                <div class="d-flex">
                <form action="' . route('user.delete', $user->id) . '" method="POST">
                    <input type="hidden" name="_token" value="' . @csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah anda yakin ingin menghapus?\');">
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
                $status =  ($user->status =='active' ) ? 'Active' : 'Inactive';
                $class = ($user->status =='active' ) ? 'badge-success' : 'badge-danger';
                return '<span class="badge ' . $class . '">' . $status . '</span>';
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
        $userDelete = $user->delete();
        if ($userDelete) {
            Session::flash('success','Berhasil Menghapus Data');
        }
        return redirect('user');
    }
}
?>
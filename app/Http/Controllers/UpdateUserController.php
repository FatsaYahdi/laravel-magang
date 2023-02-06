<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UpdateUserController extends Controller
{
    public function edit($id)
    {
        $gender = Auth::user()->gender;
        Session::flash('gender', $gender);
        return view('edit');
    }
    
    public function update(Request $req)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $req->validate([
            'name' => 'required|string',
            'address' => 'required|string|',
            'birth' => 'required|date',
            'gender' => 'required|string',
        ]);
        $data = 
        [
            'name' => $req->name,
            'address' => $req->address,
            'birth' => $req->birth,
            'gender' => $req->gender,
        ];
        $user->update($data);
        return redirect('/');
    }
}

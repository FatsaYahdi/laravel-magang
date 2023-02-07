<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
            'address' => 'required|string',
            'birth' => 'required|date',
            'gender' => 'required|string',
            'pp' => 'nullable|image',
        ]);
        $data = 
        [
            'name' => $req->name,
            'address' => $req->address,
            'birth' => $req->birth,
            'gender' => $req->gender,
        ];
        if ($req->hasFile('pp')) {
            $pp = $req->file('pp');
            $fileName = $pp->getClientOriginalName();
            $pp->storeAs('public/images/', $fileName);

        if ($user->pp !== null) {
            Storage::delete('public/images/' . $user->pp);
        }
            $data['pp'] = $fileName;
        }
        $user->update($data);
        return redirect('/');
    }
}

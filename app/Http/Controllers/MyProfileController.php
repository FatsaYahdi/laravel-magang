<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MyProfileController extends Controller
{
    public function index()
    {
        $gender = Auth::user()->gender;
        Session::flash('gender', $gender);
        return view('my-profile.index');
    }
    public function update(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $request->validate([
            'name' => 'required|string|min:3',
            'address' => 'nullable|string|min:3',
            'birth' => 'nullable|date',
            'gender' => 'nullable|string',
            'pp' => 'nullable|image',
        ]);
        $data = 
        [
            'name' => $request->name,
            'address' => $request->address,
            'birth' => $request->birth,
            'gender' => $request->gender,
        ];
        if ($request->hasFile('pp')) {
            $pp = $request->file('pp');
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
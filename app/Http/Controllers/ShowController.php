<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ShowController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('show', compact('user'));
    }

    public function update(Request $request,User $id)
    {
        $request->validate(
            [
                'name' => 'string',
                'birth' => 'date|nullable',
                'gender' => 'string|nullable',
                'address' => 'string|nullable',
                'pp' => 'nullable',
                'status' => 'string',
            ],
        );


        $imgName = '';
        if ($request->file('pp')) {
            $imgName = $request->file('pp')->getClientOriginalExtension();

            $request->file('pp')->storeAs('public/images/', $imgName);
        }

        $data =
            [
                'pp' => $imgName,
                'name' => $request->name,
                'birth' => $request->birth,
                'gender' => $request->gender,
                'address' => $request->address,
                'role' => $request->role,
                'status' => $request->status,
            ];
           $find = User::findOrFail($id->id);
           $find->update($data);

          return redirect('/user');
    }
}

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
        $find = User::findOrFail($id->id);
        $request->validate(
            [
                'name' => 'string',
                'birth' => 'date|nullable',
                'gender' => 'string|nullable',
                'address' => 'string|nullable',
                'pp' => 'nullable',
            ],
        );

        $data =
            [
                'name' => $request->name,
                'birth' => $request->birth,
                'gender' => $request->gender,
                'address' => $request->address,
                'role' => $request->role,
            ];

            if ($request->hasFile('pp')) {
                $pp = $request->file('pp');
                $imgName = $pp->getClientOriginalName();
                $pp->storeAs('public/images/', $imgName);
    
                if ($find->pp !== null) {
                    Storage::delete('public/images/' . $find->pp);
                }
                $data['pp'] = $imgName;
            }
        
        $find->update($data);

          return redirect('/user');
    }
}

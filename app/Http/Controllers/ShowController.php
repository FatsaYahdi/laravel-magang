<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ShowController extends Controller
{
    public function show()
    {
        $users = User::all();
        return view('show',compact('users'));
    }
    public function destroy($id)
    {
        $item = User::findOrFail($id);
        $path = public_path('storage/images/'.$item->pp);
        if(File::exists($path)) {
            File::delete($path);
        }
        $item->delete();

        return redirect('/');
    }
}

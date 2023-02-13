<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ShowController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('show',compact('user'));
    }
    // public function destroy($id)
    // {
    //     $item = User::findOrFail($id);
    //     $path = public_path('storage/images/'.$item->pp);
    //     if(File::exists($path)) {
    //         File::delete($path);
    //     }
    //     $item->delete();

    //     return redirect('/');
    // }
}

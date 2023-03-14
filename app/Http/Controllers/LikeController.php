<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request, $post)
    {
        $like = Like::where('post_id', $post)->where('user_id',auth()->user()->id)->first();
        if ($like) {
            $like->delete();
            return redirect()->back();
        } else {
            Like::create([
                'post_id' => $post,
                'user_id' => auth()->user()->id
            ]);
            return redirect()->back();
        }
    }
}

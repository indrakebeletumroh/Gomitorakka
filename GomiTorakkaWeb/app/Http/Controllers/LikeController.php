<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        $postId = $request->post_id;

        Like::create([
            'user_id' => Auth::user()->uid,
            'post_id' => $postId,
        ]);

        return response()->json(['status' => 'liked']);
    }

    public function toggleLike($postId)
{
    if (!session('logged_in') || !session('uid')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $userId = session('uid');

    $like = Like::where('user_id', $userId)->where('post_id', $postId)->first();

    if ($like) {
        $like->delete();
        $status = 'unliked';
    } else {
        Like::create([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);
        $status = 'liked';
    }

    $likesCount = Like::where('post_id', $postId)->count();

    return response()->json([
        'status' => $status,
        'likesCount' => $likesCount,
    ]);
}

}

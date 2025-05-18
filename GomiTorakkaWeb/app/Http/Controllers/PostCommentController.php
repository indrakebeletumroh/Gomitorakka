<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostComment;
use App\Models\User;

class PostCommentController extends Controller
{
   public function store(Request $request, $postId)
{
    $request->validate(['comment' => 'required|string|max:1000']);

    $comment = PostComment::create([
        'post_id' => $postId,
        'uid' => session('uid'),
        'comment' => $request->comment,
    ]);

    $user = User::find(session('uid'));

    return response()->json([
        'success' => true,
        'comment' => [
            'username' => $user->username,
            'user_image' => $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('/images/download.png'),
            'comment' => $comment->comment,
        ]
    ]);
}

}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {

        $posts = Post::withCount('comments')
             ->orderBy('created_at', 'desc')
             ->get();


        return view('feed', ['posts' => $posts]);
    }

    public function store(Request $request)
    {
        try {
            // Validasi login
            if (!Session::has('logged_in') || !Session::get('logged_in')) {
                return redirect()->route('login');
            }

            // Validasi input
            $request->validate([
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Simpan post
            $post = new Post();
            $post->user_id = Session::get('uid'); // Pastikan ini string
            $post->content = $request->content;

            // Handle upload gambar
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('posts', $filename, 'public');
                $post->image = $path;
            }

            $post->save();

            return redirect()->route('posts.index')->with('success', 'Post berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal upload: ' . $e->getMessage());
        }
    }

   public function toggleLike($postId)
{
    try {
        $userId = session('uid'); // pastikan session ada

        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

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
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function fetchComments($postId)
{
    $comments = PostComment::with('user')
        ->where('post_id', $postId)
        ->latest()
        ->get();

    return response()->json($comments);
}

}

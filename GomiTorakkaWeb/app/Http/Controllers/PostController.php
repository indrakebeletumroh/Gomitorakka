<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function index()
    {
        if (!Session::has('logged_in') || !Session::get('logged_in')) {
            return redirect()->route('login');
        }

        $posts = Post::orderBy('created_at', 'desc')->get();

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


}

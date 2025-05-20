<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Tampilkan halaman User Management dengan data user
    public function UserPanel(Request $request)
    {
        // Ambil filter role dan search dari request (jika ada)
        $roleFilter = $request->input('role', ''); // kosong berarti all
        $search = $request->input('search', '');

        $query = User::query();

        // Filter berdasarkan role jika dipilih
        if ($roleFilter && $roleFilter !== 'All Roles') {
            $query->where('role', strtolower($roleFilter));
        }

        // Filter berdasarkan search username atau email
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Urutkan terbaru dulu dan paginate 10 data per halaman
        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        // Kirim data users ke view UserPanel.blade.php
        return view('UserPanel', compact('users', 'roleFilter', 'search'));
    }

    // Hapus user dengan pengecekan supaya user tidak bisa hapus akun sendiri
    public function destroy($uid)
    {
        if (Auth::user()->uid === $uid) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        $user = User::where('uid', $uid)->firstOrFail();
        $user->delete();

        return redirect()->route('user.panel')->with('success', 'User deleted successfully');
    }
}

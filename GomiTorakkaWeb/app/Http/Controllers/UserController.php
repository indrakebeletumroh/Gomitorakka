<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            $query->where(function ($q) use ($search) {
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


    
    public function update(Request $request, $uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();

        // Validasi input
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:1',
            'role' => 'required|in:user,admin',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->update($validated);

        return redirect()->route('user.panel')->with('success', 'User updated successfully');
    }

    public function destroy($uid)
    {
        // Cegah user tidak login
        if (!session()->has('role') || session('role') !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Cegah admin menghapus dirinya sendiri
        if (session('uid') == $uid) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        // Temukan user
        $user = User::where('uid', $uid)->firstOrFail();

        // Hapus user
        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    public function promoteToAdmin($uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();
        $user->role = 'admin';
        $user->save();

        return redirect()->back()->with('success', $user->username . ' telah dipromosikan menjadi admin.');
    }

    public function deactivate($uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();
        $user->is_active = false;
        $user->save();

        return redirect()->back()->with('success', 'User deactivated successfully.');
    }

    public function activate($uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();
        $user->is_active = true;
        $user->save();

        return redirect()->back()->with('success', 'User activated successfully.');
    }
}

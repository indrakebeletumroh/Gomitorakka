<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Show User Management Panel
    public function UserPanel()
    {
        $users = User::withCount('markers')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('UserPanel', compact('users'));
    }

    // Delete User (with protection)
    public function destroy($uid)
    {
        // Prevent self-deletion
        if (Auth::user()->uid === $uid) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account!');
        }

        $user = User::where('uid', $uid)->firstOrFail();
        $user->delete();

        return redirect()->route('user.panel')
            ->with('success', 'User deleted successfully');
    }
    
}
<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function form_register(){
        return view('register');
    }

    function submit(Request $request){
        $users = new users();
        $users->age = $request->age;
        $users->username = $request->username;
        $users->phone_number = $request->phone_number;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        
        $users->save();

        return redirect()->route('form_login.tampil');
    }

    function form_login() {
        return view('login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
    
        $user = users::where('username', $request->username)->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
            // Simpan semua data yang diperlukan ke session
            Session::put([
                'user_id' => $user->id,
                'uid' => $user->uid,
                'age' => $user->age,
                'username' => $user->username,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'logged_in' => true
            ]);
    
            return redirect()->route('profile');
        } else {
            return back()->withErrors([
                'login' => 'Username atau password salah.',
            ]);
        }
    }

    // Tambahkan method untuk profile page
    public function profile()
    {
        // Cek apakah user sudah login
        if (!Session::has('logged_in')) {
            return redirect()->route('form_login.tampil');
        }

        // Ambil data dari session
        $userData = [
            'username' => Session::get('username'),
            'email' => Session::get('email'),
            'phone_number' => Session::get('phone_number')
        ];

        return view('profile', ['user' => $userData]);
    }

    // Tambahkan method untuk logout
    public function logout()
    {
        // Hapus semua session
        Session::flush();
        
        return redirect('/');
    }
}
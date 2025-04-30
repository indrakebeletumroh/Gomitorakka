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
    
        $users = users::where('username', $request->username)->first();
    
        if ($users && Hash::check($request->password, $users->password)) {
            // Login berhasil
            // Simpan user ke session jika perlu
            session(['loggedInUser' => $users]);
    
            return redirect('maps');
        } else {
            // Gagal login
            return back()->withErrors([
                'login' => 'Username atau password salah.',
            ]);
        }
    }

}
